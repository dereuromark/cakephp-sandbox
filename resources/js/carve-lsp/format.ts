/*
 * Conservative Carve formatter.
 *
 * Carve source does not have a canonical serializer, and whitespace that looks
 * cosmetic can be structural: a second blank line detaches captions, trailing
 * blank lines can belong to an unclosed fence, and trailing spaces are content
 * in line blocks. Preserve every source byte except for adding a missing final
 * line ending, which is render-equivalent and keeps the formatter idempotent.
 */

import { sourceLines } from './position.js'
import { bareMarkerItem, completedItem, listItems, listTree, type ItemSite, type TreeItem } from './list-items.js'

export function formatDocument(source: string): string {
  if (source === '' || source.endsWith('\n')) return source
  return source + (source.includes('\r\n') ? '\r\n' : '\n')
}

export function formatRange(source: string, startLine: number, endLine: number): string {
  const eol = source.includes('\r\n') ? '\r\n' : '\n'
  return source.split(/\r?\n/).slice(startLine, endLine + 1).join(eol)
}

/** Prefix inserted after Enter for container-shaped lines. */
export function continuationPrefix(source: string, line: number): string {
  const previous = source.split(/\r?\n/)[line - 1] ?? ''
  const container = /^(\s*)(:{3,}) [^\s].*$/.exec(previous)
  if (container) return `\n${container[1]}${container[2]}`
  const quote = /^(\s*(?:> )+)/.exec(previous)
  if (quote) return quote[1]!
  const table = /^(\s*)\|/.exec(previous)
  if (table) return `${table[1]}| `
  // A description marker is a colon, a run of SPACES, then something. PART 2
  // (MARKER REQUIRES CONTENT, carve#1830, corpus 439) makes a colon followed by
  // only whitespace a paragraph, so there is no description to continue - and a
  // tab separator is not a marker either. The separator run sets the body's
  // content column (corpus 424), so the continuation is as wide as it is rather
  // than always two.
  //
  // The lookahead asks whether the REST OF THE LINE is blank, not whether the
  // next character is non-blank, on purpose: `: ` followed by a tab is the case
  // carve#1836 rules and every engine is still wrong about, so this decides it
  // neither way and keeps the answer it already gave.
  const definition = /^([ \t]*)(: +)(?![ \t]*$)/.exec(previous)
  if (definition) return definition[1]! + ' '.repeat(definition[2]!.length)
  return ''
}

export interface ContinuationEdit {
  range: { start: { line: number; character: number }; end: { line: number; character: number } }
  newText: string
}

const BULLET = /^([ \t]*)([-*])([ \t]+)/
const BARE_DOT = /^([ \t]*)(\.)([ \t]+)/
const ORDERED = /^([ \t]*)([0-9]+|[A-Za-z]+)([.)])([ \t]+)/
const TASK = /^\[[ xX_>?-]\]( [ \t]*|$)/
// A marker and its separator alone on a line, as the continuation writes it. A
// lone `-` with no separator is left alone: it may be prose. The separator must
// open with a space and roman numerals are single-case, as the parser reads them;
// `-<tab>` or `iV.` is text and must not be deleted. Only bullets carry a task
// box; after an ordered marker `[ ]` is text.
const BARE_MARKER = /^[ \t]*(?:[-*] [ \t]*(?:\[ \] [ \t]*)?|(?:\.|(?:[0-9]+|[A-Za-z]|[ivxlcdm]+|[IVXLCDM]+)[.)]) [ \t]*)$/

/**
 * Enter after a list item writes the next marker; Enter after a content-less
 * marker removes it, which ends the list. Inside a container the marker comes
 * after the container's own prefix (`> - `), as one edit. Returns null when
 * the line before the cursor is not a list line, so other continuations can run.
 */
export function listContinuationEdits(source: string, position: { line: number; character: number }): ContinuationEdit[] | null {
  const lines = sourceLines(source)
  const current = lines[position.line] ?? ''
  if (current.trim() !== '' || position.line === 0) return null
  const prevLine = position.line - 1
  const previous = lines[prevLine] ?? ''
  const item = listItems(source)?.starts.get(prevLine)

  if (!item || BARE_MARKER.test(previous.slice(item.character))) {
    const bare = bareMarkerItem(source, prevLine, previous)
    if (!bare || !BARE_MARKER.test(previous.slice(bare.character))) return null
    // Keep the container open: `> - ` becomes `>`, a blank quote line that ends
    // the list, and the cursor line gets `> ` so the next paragraph stays quoted.
    const lead = previous.slice(0, bare.character)
    const edits: ContinuationEdit[] = [{ range: { start: { line: prevLine, character: 0 }, end: { line: prevLine, character: previous.length } }, newText: lead.trimEnd() }]
    if (lead.includes('>')) edits.push({ range: { start: { line: position.line, character: 0 }, end: position }, newText: continuationLead(lead) })
    return edits
  }

  const marker = nextMarker(previous.slice(item.character), item)
  if (marker === null) return null
  const text = continuationLead(previous.slice(0, item.character)) + marker
  // The engine has the last word on whether the guess lands in the same list.
  if (completedItem(source, position.line, `${text}x`)?.list !== item.list) return null
  return [{ range: { start: { line: position.line, character: 0 }, end: position }, newText: text }]
}

/**
 * The prefix a new line needs to stay in the containers a marker sits in.
 * Quote markers repeat; a footnote label gives way to the two-space body
 * indent; a description colon gives way to spaces up to its body column.
 */
function continuationLead(lead: string): string {
  return lead
    .replace(/^((?:[ \t]*>)*[ \t]*)\[\^[^\]]*\]: +/, '$1  ')
    .replace(/(?<=^|[ \t>]):( +)/g, (_, gap: string) => ' ' + gap)
}

export type ListIndentDirection = 'indent' | 'outdent'

// A list marker and its separator, read at the column the parse puts the item.
const ITEM_MARKER = /^([-*.]|(?:[0-9]+|[A-Za-z]+)[.)])([ \t]+)/
// The part of a line's lead that belongs to containers (quotes, a footnote
// label, a description colon), which indenting never touches.
const CONTAINER_LEAD = /^(?:[ \t]*> ?)*(?:[ \t]*\[\^[^\]]*\]: +|[ \t]*: +)?/
const QUOTE_LEVEL = /^[ \t]*> ?/

/**
 * Tab and Shift+Tab on a list line. Indent nests the item under its previous
 * sibling, at that sibling's content column; outdent moves it to its parent's
 * level. The item's own lines and children move with it. Returns null when
 * there is nothing to nest under or out of, so the host keeps its own Tab.
 */
export function listIndentEdits(source: string, line: number, direction: ListIndentDirection): ContinuationEdit[] | null {
  const lines = sourceLines(source)
  const text = lines[line]
  if (text === undefined) return null
  let completed = lines
  let tree = listTree(source)
  let item = tree?.get(line)
  // A content-less marker is paragraph text; read it as the item it becomes.
  if (!item || BARE_MARKER.test(text.slice(item.character))) {
    completed = lines.map((entry, index) => (index === line ? `${entry}x` : entry))
    tree = listTree(completed.join('\n'))
    item = tree?.get(line)
    if (!tree || !item || !BARE_MARKER.test(text.slice(item.character))) return null
  }
  const own = ITEM_MARKER.exec(text.slice(item.character))
  if (!own) return null
  const lead = text.slice(0, item.character)
  const fixed = CONTAINER_LEAD.exec(lead)![0].length
  const indent = lead.slice(fixed)
  if (/[^ \t]/.test(indent)) return null
  const shape: Shape = { line, fixed, indent, marker: own[1]!, separator: own[2]!, quotes: (lead.slice(0, fixed).match(/>/g) ?? []).length }

  if (direction === 'indent') {
    const index = item.list.items.indexOf(item)
    const previous = item.list.items[index - 1]
    if (!previous) return null
    const width = ITEM_MARKER.exec(completed[previous.line]!.slice(previous.character))?.[0].length
    if (!width) return null
    const marker = indentedMarker(completed, item, previous, shape.marker)
    for (const delta of unique([width, previous.character + width - item.character]).filter((value) => value > 0)) {
      const result = shiftItem(completed, item, shape, delta, marker)
      const after = listTree(result.text)
      if (after?.get(line)?.parent?.key === previous.key && keepsDescendants(tree!, after, item)) return result.edits
    }
    return null
  }

  const parent = item.parent
  if (!parent) return null
  const parentMarker = ITEM_MARKER.exec(completed[parent.line]!.slice(parent.character))
  if (!parentMarker) return null
  const marker = ordinalOf(shape.marker) && parent.list.ordered && ordinalOf(shape.marker)!.delim === parent.list.delim
    ? nextOrdinal(completed, parent, parent.list) ?? shape.marker
    : shape.marker
  const widths = [item.character - parent.character, parentMarker[0].length]
  for (let width = indent.length; width > 0; width--) widths.push(width)
  for (const removed of unique(widths).filter((value) => value > 0 && value <= indent.length)) {
    const result = shiftItem(completed, item, shape, -removed, marker)
    const after = listTree(result.text)
    const moved = after?.get(line)
    if (moved && moved.parent?.key === parent.parent?.key && moved.container === parent.container && keepsDescendants(tree!, after!, item)) return result.edits
  }
  return null
}

/** Every item nested in `item` before the move is still nested in it, as deep as before. */
function keepsDescendants(before: Map<number, TreeItem>, after: Map<number, TreeItem>, item: TreeItem): boolean {
  const moved = after.get(item.line)
  if (!moved) return false
  for (let line = item.line + 1; line <= item.endLine; line++) {
    const old = before.get(line)
    if (!old) continue
    const depth = levelsBelow(old, item.key)
    if (depth === null) continue
    const now = after.get(line)
    if (!now || levelsBelow(now, moved.key) !== depth) return false
  }
  return true
}

function levelsBelow(item: TreeItem, ancestor: string): number | null {
  let levels = 0
  for (let current = item.parent; current; current = current.parent) {
    levels++
    if (current.key === ancestor) return levels
  }
  return null
}

interface Shape { line: number; fixed: number; indent: string; marker: string; separator: string; quotes: number }

function unique(values: number[]): number[] {
  return [...new Set(values)]
}

function ordinalOf(marker: string): { ordinal: string; delim: string } | null {
  const match = /^([0-9]+|[A-Za-z]+)([.)])$/.exec(marker)
  return match ? { ordinal: match[1]!, delim: match[2]! } : null
}

/** The marker of the item after `last` in `list`, or null when it has no successor. */
function nextOrdinal(lines: string[], last: TreeItem, list: { olType?: string }): string | null {
  const current = ordinalOf(ITEM_MARKER.exec(lines[last.line]!.slice(last.character))?.[1] ?? '')
  if (!current) return null
  const next = increment(current.ordinal, list.olType)
  return next === null ? null : next + current.delim
}

/**
 * A bullet keeps its character. An ordered item joining the child list its new
 * parent already ends with takes that list's next ordinal; one that starts a
 * child list restarts at the style's first ordinal.
 */
function indentedMarker(lines: string[], item: TreeItem, parent: TreeItem, marker: string): string {
  const own = ordinalOf(marker)
  if (!own) return marker
  const tail = parent.lists.at(-1)
  const last = tail?.items.at(-1)
  if (tail && last && last.endLine === parent.endLine && tail.ordered && tail.delim === own.delim) {
    const next = nextOrdinal(lines, last, tail)
    if (next) return next
  }
  return (item.list.olType ?? '1') + own.delim
}

/**
 * Moves the item line's marker by `delta` columns (negative removes indent)
 * and writes `marker`; every later line of the item moves with its content
 * column, so it stays in the item when the marker changes width.
 */
function shiftItem(lines: string[], item: TreeItem, shape: Shape, delta: number, marker: string): { edits: ContinuationEdit[]; text: string } {
  const edits: ContinuationEdit[] = []
  const next = [...lines]
  const indent = delta > 0 ? shape.indent + ' '.repeat(delta) : shape.indent.slice(0, shape.indent.length + delta)
  const replacement = indent + marker + shape.separator
  const end = shape.fixed + shape.indent.length + shape.marker.length + shape.separator.length
  edits.push({ range: { start: { line: shape.line, character: shape.fixed }, end: { line: shape.line, character: end } }, newText: replacement })
  next[shape.line] = next[shape.line]!.slice(0, shape.fixed) + replacement + next[shape.line]!.slice(end)
  const shift = delta + marker.length - shape.marker.length
  for (let line = item.line + 1; line <= item.endLine; line++) {
    const text = lines[line]!
    let at = 0
    let level = 0
    while (level < shape.quotes) {
      const quote = QUOTE_LEVEL.exec(text.slice(at))
      if (!quote) break
      at += quote[0].length
      level++
    }
    // A lazy line (fewer quote markers) or a blank one is left as written.
    if (level < shape.quotes || text.slice(at).trim() === '' || shift === 0) continue
    if (shift > 0) {
      edits.push({ range: { start: { line, character: at }, end: { line, character: at } }, newText: ' '.repeat(shift) })
      next[line] = text.slice(0, at) + ' '.repeat(shift) + text.slice(at)
    } else {
      const removable = Math.min(-shift, /^[ \t]*/.exec(text.slice(at))![0].length)
      if (removable === 0) continue
      edits.push({ range: { start: { line, character: at }, end: { line, character: at + removable } }, newText: '' })
      next[line] = text.slice(0, at) + text.slice(at + removable)
    }
  }
  return { edits, text: next.join('\n') }
}

function nextMarker(line: string, item: ItemSite): string | null {
  const bullet = BULLET.exec(line)
  if (bullet) return bullet[1]! + bullet[2]! + bullet[3]! + taskBox(line.slice(bullet[0].length))
  const dot = BARE_DOT.exec(line)
  if (dot) return dot[1]! + dot[2]! + dot[3]!
  const ordered = ORDERED.exec(line)
  if (!ordered || ordered[3] !== item.delim) return null
  const [, indent, ordinal, delim, separator] = ordered as unknown as [string, string, string, string, string]
  const next = increment(ordinal, item.olType)
  if (next === null) return null
  // Keep the content column when the marker changes width (9. -> 10., iii. -> iv.),
  // but never drop below one space. A tab separator is copied as written.
  const width = ordinal.length + delim.length + separator.length
  const gap = /\t/.test(separator) ? separator : ' '.repeat(Math.max(1, width - next.length - delim.length))
  return indent + next + delim + gap
}

function taskBox(body: string): string {
  const task = TASK.exec(body)
  return task ? `[ ]${task[1] || ' '}` : ''
}

function increment(ordinal: string, olType: string | undefined): string | null {
  if (/^[0-9]+$/.test(ordinal)) return (BigInt(ordinal) + 1n).toString().padStart(ordinal.length, '0')
  if (olType === 'i' || olType === 'I') {
    const value = fromRoman(ordinal.toLowerCase())
    if (value === null) return null
    const roman = toRoman(value + 1)
    return olType === 'I' ? roman.toUpperCase() : roman
  }
  if ((olType === 'a' || olType === 'A') && ordinal.length === 1) {
    if (ordinal === 'z' || ordinal === 'Z') return null
    return String.fromCharCode(ordinal.charCodeAt(0) + 1)
  }
  return null
}

const ROMAN: Array<[number, string]> = [
  [1000, 'm'], [900, 'cm'], [500, 'd'], [400, 'cd'], [100, 'c'], [90, 'xc'],
  [50, 'l'], [40, 'xl'], [10, 'x'], [9, 'ix'], [5, 'v'], [4, 'iv'], [1, 'i'],
]

function toRoman(value: number): string {
  let out = ''
  for (const [amount, digits] of ROMAN) while (value >= amount) { out += digits; value -= amount }
  return out
}

function fromRoman(text: string): number | null {
  let value = 0
  let rest = text
  for (const [amount, digits] of ROMAN) while (rest.startsWith(digits)) { value += amount; rest = rest.slice(digits.length) }
  return rest === '' && value > 0 ? value : null
}
