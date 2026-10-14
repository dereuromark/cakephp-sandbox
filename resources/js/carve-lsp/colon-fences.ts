import { DiagnosticSeverity, DocumentHighlightKind, InlayHintKind, type Diagnostic, type DocumentHighlight, type Hover, type InlayHint, type Position, type Range } from 'vscode-languageserver-types'
import { parse } from '@markup-carve/carve'
import { astColumnToCharacter } from './position.js'

interface UnclosedContainer { kind: string; line: number; column: number; startOffset: number; endOffset: number; fenceWidth: number }

export interface FenceSite { kind: string; width: number; range: Range }
export interface FencePair { opener: FenceSite; closer: FenceSite }

/**
 * Node types the parser reads verbatim. A `:::` line inside one of them is text,
 * not a fence, so the closer scan below has to step over their whole extent.
 */
const OPAQUE_TYPES = new Set(['code_block', 'raw_block', 'comment'])

/**
 * Labels for the node types whose humanized `type` would read wrong. This map is
 * NOT a gate: a colon-fence node type missing from it still gets a site, a pair
 * and a label - it only loses the hyphen. That is the difference from the chain
 * this replaced, where an unnamed type returned `null` and every consumer of
 * `colonFenceStructure` silently skipped the container (#157).
 */
const FENCE_KIND_LABELS: Record<string, string> = { hard_break_block: 'hard-break block' }

export function colonFenceStructure(source: string): { openers: FenceSite[]; pairs: FencePair[]; diagnostics: Diagnostic[] } {
  const lines = source.replace(/\r\n?/g, '\n').split('\n')
  const unclosed: UnclosedContainer[] = []
  const document = parse(source, { positions: true, onUnclosedContainer: (site) => unclosed.push(site) })
  const key = (line: number, column: number, width: number) => `${line}:${column}:${width}`
  // Keys use UTF-16 columns, the unit every FenceSite range carries.
  const unclosedKeys = new Set(unclosed.map((site) => key(site.line, astColumnToCharacter(lines[site.line - 1] ?? '', site.column) + 1, site.fenceWidth)))
  const openers = new Map<number, FenceSite>()
  const opaque: Array<readonly [number, number]> = []
  const diagnostics: Diagnostic[] = []
  const walk = (value: unknown, parent: FenceSite | null): void => {
    if (Array.isArray(value)) { for (const child of value) walk(child, parent); return }
    if (!value || typeof value !== 'object') return
    const node = value as Record<string, unknown>
    if (OPAQUE_TYPES.has(String(node.type ?? ''))) { const span = lineSpan(node); if (span) opaque.push(span) }
    const site = astFenceSite(node, lines)
    const nextParent = site ?? parent
    if (site) {
      // A parent is walked before its children, so the innermost site on a line wins.
      openers.set(site.range.start.line, site)
      const siteKey = key(site.range.start.line + 1, site.range.start.character + 1, site.width)
      const run = lineRun(lines[site.range.start.line] ?? '', site.range.start.character)
      if (unclosedKeys.has(siteKey) && run?.bare && parent && site.width !== parent.width) {
        diagnostics.push({ severity: DiagnosticSeverity.Warning, source: 'carve', code: 'colon-fence-length-mismatch', range: site.range,
          message: `Bare ${site.width}-colon fence does not close the innermost ${parent.width}-colon ${parent.kind} opened at ${parent.range.start.line + 1}:${parent.range.start.character + 1}; it currently opens a nested container.`,
          data: { authoredWidth: site.width, expectedWidth: parent.width, openerLine: parent.range.start.line + 1, openerColumn: parent.range.start.character + 1, outcome: 'nested container' } })
      }
    }
    for (const [name, child] of Object.entries(node)) if (name !== 'pos' && name !== 'attrs') walk(child, nextParent)
  }
  // The whole document, not just `children`: footnote bodies hang off
  // `footnoteDefs`, and a colon fence inside one is a container like any other.
  walk(document, null)
  return { openers: [...openers.values()].sort((a, b) => a.range.start.line - b.range.start.line), pairs: pairFences(lines, openers, opaque, unclosedKeys), diagnostics }
}

/** Every colon-fence opener the server recognizes, closed or not. */
export function colonFenceOpeners(source: string): FenceSite[] {
  return colonFenceStructure(source).openers
}

export function colonFenceHighlights(source: string, position: Position): DocumentHighlight[] {
  const pair = colonFenceStructure(source).pairs.find(({ opener, closer }) => contains(opener.range, position) || contains(closer.range, position))
  return pair ? [
    { range: pair.opener.range, kind: DocumentHighlightKind.Write },
    { range: pair.closer.range, kind: DocumentHighlightKind.Read },
  ] : []
}

export function colonFenceHover(source: string, position: Position): Hover | null {
  const pair = colonFenceStructure(source).pairs.find(({ closer }) => contains(closer.range, position))
  if (!pair) return null
  return {
    contents: { kind: 'markdown', value: `**${pair.opener.kind} closer**\n\nEnds the ${pair.opener.width}-colon container from ${pair.opener.range.start.line + 1}:${pair.opener.range.start.character + 1} through ${pair.closer.range.end.line + 1}:${pair.closer.range.end.character + 1}.` },
    range: pair.closer.range,
  }
}

export function colonFenceInlayHints(source: string, range: Range): InlayHint[] {
  return colonFenceStructure(source).pairs
    .filter(({ closer }) => closer.range.start.line >= range.start.line && closer.range.start.line <= range.end.line)
    .map(({ opener, closer }) => ({ position: closer.range.end, label: ` closes ${opener.kind} from line ${opener.range.start.line + 1}`, kind: InlayHintKind.Type, paddingLeft: true }))
}

export function linkedColonFenceRanges(source: string, position: Position): { ranges: Range[]; wordPattern: string } | null {
  const pair = colonFenceStructure(source).pairs.find(({ opener, closer }) => contains(opener.range, position) || contains(closer.range, position))
  return pair ? { ranges: [pair.opener.range, pair.closer.range], wordPattern: ':{3,}' } : null
}

/**
 * Pair each opener with its closer by walking the source once.
 *
 * The extents cannot do this. A `div`, an `admonition` and a `figure_group` span
 * their closing fence; a `::: >` block quote spans only its content, and a nested
 * container's closer can sit on the very line its extent ends. Deriving the
 * closer from `pos.end` therefore reads the wrong line for some kinds and no line
 * for others - which is the second half of #157, under the missing kind.
 *
 * A bare run closes the innermost open container only when the widths match
 * EXACTLY (carve#455); at any other width it opens a nested container, and the
 * parser has already told us so by giving that line a node of its own.
 *
 * An opener the parser reports unclosed never joins the stack: inside a block
 * quote it can end with the quote, and a later bare run belongs to an outer one.
 */
function pairFences(lines: string[], openers: Map<number, FenceSite>, opaque: Array<readonly [number, number]>, unclosed: Set<string>): FencePair[] {
  const pairs: FencePair[] = []
  const stack: FenceSite[] = []
  // Flattened once. Testing every span per line is quadratic in a document made
  // mostly of code blocks, and this runs on the highlight and hover paths.
  const verbatim = new Uint8Array(lines.length)
  for (const [from, to] of opaque) {
    for (let line = Math.max(0, from); line <= Math.min(lines.length - 1, to); line++) verbatim[line] = 1
  }
  for (let line = 0; line < lines.length; line++) {
    if (verbatim[line]) continue
    const opener = openers.get(line)
    if (opener) {
      if (!unclosed.has(`${line + 1}:${opener.range.start.character + 1}:${opener.width}`)) stack.push(opener)
      continue
    }
    const top = stack[stack.length - 1]
    if (!top) continue
    const column = closerColumn(lines[top.range.start.line] ?? '', top.range.start.character)
    const text = lines[line] ?? ''
    // The closer repeats the opener's quote markers; a list marker before the opener is indent here.
    const prefix = text.slice(0, column)
    if (!/^(?:[ \t]*> )*[ \t]*$/.test(prefix) || quoteDepth(prefix) !== quoteDepth(lines[top.range.start.line] ?? '')) continue
    const run = lineRun(text, column)
    if (!run?.bare || run.width !== top.width) continue
    pairs.push({ opener: top, closer: fenceSite(line, column, run.width, top.kind) })
    stack.pop()
  }
  return pairs
}

/** A footnote label before the opener gives way to the two-space body indent its closer sits at. */
function closerColumn(openerLine: string, column: number): number {
  const label = /^((?:[ \t]*> )*[ \t]*)\[\^[^\]]*\]: +$/.exec(openerLine.slice(0, column))
  return label ? label[1]!.length + 2 : column
}

function quoteDepth(line: string): number {
  return /^(?:[ \t]*> )*/.exec(line)![0].split('>').length - 1
}

function fenceSite(line: number, character: number, width: number, kind: string): FenceSite {
  return { kind, width, range: { start: { line, character }, end: { line, character: character + width } } }
}
/**
 * A colon fence is recognized by the shape the schema describes - a block
 * container (it carries `children`) whose start position lands on a `:::` run -
 * rather than by a list of node types. That is what makes a new kind work on
 * arrival: the fenced block quote is a `block_quote` carrying `fenced: true`
 * rather than a type of its own, and `figure_group` was never on the list at all.
 * The `>`-marker spelling of a quote starts on `>`, so the same test excludes it
 * without having to read `fenced`.
 */
function astFenceSite(node: Record<string, unknown>, lines: string[]): FenceSite | null {
  if (!Array.isArray(node.children) || holdsInlines(node)) return null
  const pos = node.pos as { startLine?: number; startColumn?: number } | undefined
  if (!pos?.startLine || !pos.startColumn) return null
  const text = lines[pos.startLine - 1] ?? ''
  const character = astColumnToCharacter(text, pos.startColumn)
  const run = lineRun(text, character)
  return run ? fenceSite(pos.startLine - 1, character, run.width, fenceKind(node)) : null
}

// A paragraph whose first line is a literal `:::` run starts on it too, but holds text, not blocks.
const INLINE_BLOCKS = new Set(['paragraph', 'heading'])

function holdsInlines(node: Record<string, unknown>): boolean {
  return INLINE_BLOCKS.has(String(node.type ?? '')) ||
    (node.children as unknown[]).some((child) => (child as { type?: unknown } | null)?.type === 'text')
}
function fenceKind(node: Record<string, unknown>): string {
  const type = String(node.type ?? '')
  if (type === 'admonition') return `${String(node.kind ?? '')} admonition`.trim()
  return FENCE_KIND_LABELS[type] ?? type.replace(/_/g, ' ')
}
function lineSpan(node: Record<string, unknown>): readonly [number, number] | null {
  const pos = node.pos as { startLine?: number; endLine?: number } | undefined
  return pos?.startLine && pos.endLine ? [pos.startLine - 1, pos.endLine - 1] : null
}
function lineRun(line: string, at: number): { width: number; bare: boolean } | null {
  const match = /^(:{3,})(.*)$/.exec(line.slice(at))
  return match ? { width: match[1]!.length, bare: /^[ \t]*$/.test(match[2]!) } : null
}
function contains(range: Range, p: Position): boolean {
  return p.line === range.start.line && p.character >= range.start.character && p.character <= range.end.character
}
