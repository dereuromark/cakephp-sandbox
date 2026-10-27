// CodeMirror editor for the Carve playground page, built into
// plugins/Sandbox/webroot/js/carve-editor.min.js by `composer assets`.
// `create()` replaces a textarea and returns an object with the textarea members the
// page script uses, so the page keeps one code path for both.
import { EditorState, Compartment, RangeSetBuilder, StateEffect, StateField } from '@codemirror/state'
import {
  EditorView,
  Decoration,
  type DecorationSet,
  type Command,
  keymap,
  lineNumbers,
  highlightActiveLine,
  highlightActiveLineGutter,
  drawSelection,
  highlightSpecialChars,
} from '@codemirror/view'
import { defaultKeymap, history, historyKeymap, indentMore, indentLess } from '@codemirror/commands'
import { searchKeymap, highlightSelectionMatches } from '@codemirror/search'
import { parse } from './carve-global'
import { BARE_CONTINUATION_MARKER, continuationPrefix, listContinuationEdits, listIndentEdits, type ContinuationEdit } from './carve-lsp/format'
import { bareMarkerItem, listItems } from './carve-lsp/list-items'

type Hljs = { getLanguage(name: string): unknown; highlight(code: string, o: { language: string; ignoreIllegals?: boolean }): { value: string } }

// --- Highlighting: highlight.js with the Carve grammar the page already loads.
// The editor gives Carve's overloaded inline token classes their own styling.
const setTokens = StateEffect.define<DecorationSet>()
const tokenField = StateField.define<DecorationSet>({
  create: () => Decoration.none,
  update(deco, tr) {
    for (const e of tr.effects) if (e.is(setTokens)) return e.value
    return tr.docChanged ? deco.map(tr.changes) : deco
  },
  provide: (f) => EditorView.decorations.from(f),
})

const markCache = new Map<string, Decoration>()
function markFor(cls: string): Decoration {
  let m = markCache.get(cls)
  if (!m) {
    m = Decoration.mark({ class: cls })
    markCache.set(cls, m)
  }
  return m
}

// highlight.js shares palette classes across distinct Carve inline constructs.
function editorTokenClass(cls: string, text: string, from: number, to: number, substitutionInsertion: boolean, substitution: boolean): string {
  const first = text[from]
  const braced = text[from] === '{' ? text[from + 1] : ''
  const last = text[to - 1]
  const bracedLast = text.slice(to - 2, to)
  if (cls === 'hljs-addition' && !substitutionInsertion
    && ((first === '=' && last === '=') || (braced === '=' && bracedLast === '=}'))) {
    return 'hljs-carve-highlight'
  }
  if (cls === 'hljs-emphasis' && ((first === '_' && last === '_') || (braced === '_' && bracedLast === '_}'))) {
    return 'hljs-carve-underline'
  }
  if (cls === 'hljs-deletion' && !substitution && ((first === '~' && last === '~')
    || (braced === '~' && bracedLast === '~}'))) {
    return 'hljs-carve-strike'
  }
  return cls
}

function diffMarkerRanges(text: string): Array<{ from: number; to: number; cls: string }> {
  if (!/diff/i.test(text)) return []
  const lines = text.split('\n')
  const lineStarts: number[] = []
  let offset = 0
  for (const line of lines) {
    lineStarts.push(offset)
    offset += line.length + 1
  }
  const ranges: Array<{ from: number; to: number; cls: string }> = []
  const visit = (value: unknown): void => {
    if (value === null || typeof value !== 'object') return
    if (Array.isArray(value)) {
      value.forEach(visit)
      return
    }
    const node = value as {
      type?: string
      lang?: string
      attrs?: { classes?: string[] }
      content?: string
      pos?: { startLine?: number }
    }
    if (node.type === 'code_block' && (node.lang?.toLowerCase() === 'diff' || node.attrs?.classes?.includes('diff'))
      && node.pos?.startLine && node.content) {
      node.content.split('\n').forEach((contentLine, index) => {
        const marker = contentLine[0]
        if (marker !== '+' && marker !== '-') return
        const sourceLineIndex = node.pos!.startLine! + index
        const sourceLine = lines[sourceLineIndex]
        const column = sourceLine?.lastIndexOf(contentLine) ?? -1
        if (column < 0) return
        const from = lineStarts[sourceLineIndex] + column
        ranges.push({ from, to: from + 1, cls: marker === '+' ? 'cm-carve-diff-add' : 'cm-carve-diff-remove' })
      })
      return
    }
    for (const [key, child] of Object.entries(node)) {
      if (key !== 'pos' && key !== 'attrs') visit(child)
    }
  }
  try {
    visit(parse(text, { positions: true }))
  } catch {
    return []
  }
  return ranges
}

function tokenize(text: string): DecorationSet | null {
  const hljs = (globalThis as { hljs?: Hljs }).hljs
  if (!hljs || !hljs.getLanguage('carve')) return null
  const tpl = document.createElement('template')
  tpl.innerHTML = hljs.highlight(text, { language: 'carve', ignoreIllegals: true }).value
  // One mark per highlighted element, so spans nest as in hljs output and an inner
  // class (a keyword in an embedded fence language) keeps its own color.
  const ranges: Array<{ from: number; to: number; cls: string }> = []
  let pos = 0
  const walk = (node: Node, inSubLanguage = false): void => {
    if (node.nodeType === Node.TEXT_NODE) {
      pos += (node as Text).data.length
      return
    }
    const own = node instanceof Element ? node.className : ''
    const embedded = inSubLanguage || own.split(/\s+/).some((cls) => cls.startsWith('language-'))
    const from = pos
    node.childNodes.forEach((child) => walk(child, embedded))
    if (own && pos > from) {
      const previous = node instanceof Element ? node.previousElementSibling : null
      const substitutionInsertion = previous?.classList.contains('hljs-punctuation') && previous.textContent === '~>'
      const substitution = node instanceof Element && Array.from(node.children).some((child) =>
        child.classList.contains('hljs-punctuation') && child.textContent === '~>')
      const tokenClass = embedded ? own : editorTokenClass(own, text, from, pos, !!substitutionInsertion, substitution)
      const cls = embedded ? tokenClass : `${tokenClass} carve-root-token`
      ranges.push({ from, to: pos, cls })
      if (tokenClass === 'hljs-carve-underline' || tokenClass === 'hljs-carve-strike') {
        const delimiterWidth = text[from] === '{' ? 2 : 1
        if (pos - from > 2 * delimiterWidth) {
          ranges.push({
            from: from + delimiterWidth,
            to: pos - delimiterWidth,
            cls: tokenClass === 'hljs-carve-underline' ? 'cm-carve-underline-content' : 'cm-carve-strike-content',
          })
        }
      }
    }
  }
  tpl.content.childNodes.forEach((child) => walk(child))
  ranges.push(...diffMarkerRanges(text))
  ranges.sort((a, b) => a.from - b.from || b.to - a.to)
  const builder = new RangeSetBuilder<Decoration>()
  for (const r of ranges) builder.add(r.from, r.to, markFor(r.cls))
  return builder.finish()
}

// --- List and container editing, from carve-lsp's on-type rules (resources/js/carve-lsp).
function applyEdits(v: EditorView, edits: ContinuationEdit[], base?: { from: number; insert: string }, assoc: 1 | -1 = 1, shift = 0): void {
  const mid = base ? v.state.update({ changes: base }) : null
  const state = mid ? mid.state : v.state
  const at = (p: { line: number; character: number }) => state.doc.line(p.line + 1).from + p.character
  const changes = state.changes(edits.map((e) => ({ from: at(e.range.start), to: at(e.range.end), insert: e.newText })))
  const cursor = base ? base.from + base.insert.length : v.state.selection.main.head
  v.dispatch({
    changes: mid ? mid.changes.compose(changes) : changes,
    selection: { anchor: changes.mapPos(cursor, assoc) + shift },
    scrollIntoView: true,
    userEvent: 'input',
  })
}

// 1-based line inside a code or raw block, fences included: no structural edits there.
function inCodeBlock(text: string, line: number): boolean {
  let found = false
  const visit = (value: unknown): void => {
    if (found || value === null || typeof value !== 'object') return
    if (Array.isArray(value)) return value.forEach(visit)
    const node = value as { type?: string; pos?: { startLine?: number; endLine?: number } }
    const { startLine, endLine } = node.pos ?? {}
    if ((node.type === 'code_block' || node.type === 'raw_block') && startLine !== undefined && endLine !== undefined) {
      if (line >= startLine && line <= endLine) found = true
      return
    }
    for (const [key, child] of Object.entries(node)) if (key !== 'pos') visit(child)
  }
  try {
    visit((parse(text, { positions: true }) as { children: unknown }).children)
  } catch {
    return false
  }
  return found
}

const continueOnEnter: Command = (v) => {
  const sel = v.state.selection
  if (sel.ranges.length !== 1 || !sel.main.empty) return false
  const pos = sel.main.head
  const line = v.state.doc.lineAt(pos)
  if (pos !== line.to) return false
  const base = { from: pos, insert: '\n' }
  const text = v.state.doc.sliceString(0, pos) + '\n' + v.state.doc.sliceString(pos)
  const position = { line: line.number, character: 0 }
  const list = listContinuationEdits(text, position)
  if (list) {
    applyEdits(v, list, base)
    return true
  }
  const prefix = continuationPrefix(text, line.number)
  // Text before the first newline goes before the cursor, a closer (`\n:::`, `> \n> :::`) after it.
  const lead = prefix.split('\n', 1)[0]!
  // The server checks closers against code itself, and a new fence opener reads as inside its own block.
  if (!prefix || (lead === prefix && inCodeBlock(text, line.number))) return false
  // A pipe-led line that is neither a table row nor a line-block line is text.
  if (/^[ \t]*\| $/.test(prefix) && !/^[ \t]*\|.*\|[ \t]*$/.test(line.text) && !/^[ \t]*\| /.test(line.text)) return false
  applyEdits(v, [{ range: { start: position, end: position }, newText: prefix }], base, -1, lead.length)
  return true
}

// A content-less marker as the continuation writes it: `- `, `- [ ] `, `2. `, `b) `.
const BARE_LIST_MARKER = /^(?:[-*] [ \t]*(?:\[[ xX_>?-]\] [ \t]*)?|(?:\.|(?:[0-9]+|[A-Za-z]|[ivxlcdm]+|[IVXLCDM]+)[.)]) [ \t]*)$/
// Checked task boxes too, plus the server's own set, which adds a bare description `: `.
const BARE_MARKER = { test: (rest: string) => BARE_LIST_MARKER.test(rest) || BARE_CONTINUATION_MARKER.test(rest) }

// Backspace at the end of an empty item removes the whole marker, keeping the
// indent and any quote prefix.
const deleteBareMarker: Command = (v) => {
  const sel = v.state.selection
  if (sel.ranges.length !== 1 || !sel.main.empty) return false
  const line = v.state.doc.lineAt(sel.main.head)
  if (sel.main.head !== line.to) return false
  const lead = /^(?:[ \t]*> ?)*[ \t]*/.exec(line.text)![0]
  const rest = line.text.slice(lead.length)
  if (!rest || !BARE_MARKER.test(rest) || inCodeBlock(v.state.doc.toString(), line.number)) return false
  v.dispatch({ changes: { from: line.from + lead.length, to: line.to }, userEvent: 'delete.backward' })
  return true
}

function listIndent(direction: 'indent' | 'outdent', fallback: Command): Command {
  return (v) => {
    const sel = v.state.selection
    if (sel.ranges.length === 1) {
      const line = v.state.doc.lineAt(sel.main.head)
      const text = v.state.doc.toString()
      const edits = listIndentEdits(text, line.number - 1, direction)
      if (edits && edits.length) {
        applyEdits(v, edits)
        return true
      }
      // A list item with nothing to nest under (or out of) stays put rather than
      // taking a plain indent that would turn it into lazy text of the item above.
      if (listItems(text)?.starts.has(line.number - 1) || bareMarkerItem(text, line.number - 1, line.text)) return true
    }
    return fallback(v)
  }
}

const theme = EditorView.theme({
  // Line numbers sit outside the box: border and fill start at the gutter's edge.
  '&': {
    height: '100%',
    fontSize: '0.875rem',
    background: 'linear-gradient(to right, transparent var(--carve-gutter-w, 0px), var(--bs-body-bg, #fff) var(--carve-gutter-w, 0px))',
  },
  '&::after': {
    content: '""',
    position: 'absolute',
    inset: '0 0 0 var(--carve-gutter-w, 0px)',
    border: 'var(--bs-border-width, 1px) solid var(--bs-border-color, #dee2e6)',
    borderRadius: 'var(--bs-border-radius, 0.375rem)',
    pointerEvents: 'none',
  },
  '&.cm-focused': { outline: 'none' },
  '&.cm-focused::after': { borderColor: '#86b7fe', boxShadow: '0 0 0 0.25rem rgba(13, 110, 253, 0.25)' },
  '.cm-scroller': { fontFamily: 'var(--bs-font-monospace, monospace)', lineHeight: '1.5', scrollBehavior: 'auto' },
  '.cm-content': { padding: '0.375rem 0' },
  '.cm-line': { padding: '0 0.75rem' },
  '.cm-gutters': { background: 'var(--bs-body-bg, #fff)', border: 'none', color: '#adb5bd', fontSize: '0.75rem' },
  '.cm-gutter.cm-lineNumbers .cm-gutterElement': { padding: '0 0.5rem 0 0' },
  '.cm-activeLine': { background: 'rgba(13, 110, 253, 0.05)' },
  '.cm-activeLineGutter': { background: 'transparent', color: '#6c757d' },
})

export interface EditorFacade {
  value: string
  selectionStart: number
  selectionEnd: number
  readonly scrollHeight: number
  readonly clientHeight: number
  readonly clientWidth: number
  scrollTop: number
  setSelectionRange(start: number, end: number): void
  focus(): void
  scrollIntoView(options?: ScrollIntoViewOptions): void
  getAttribute(name: string): string | null
  setAttribute(name: string, value: string): void
  addEventListener(type: string, listener: EventListener, options?: AddEventListenerOptions): void
  /** Top of each 0-based source line in scroll coordinates, plus a sentinel past the end. */
  lineTops(): number[]
  /** The source to render: `value` without the empty list marker the cursor sits on. */
  readonly renderValue: string
  view: EditorView
}

// A continuation leaves `- ` on the new line, which Carve reads as text, so the
// preview would show a stray marker until the item gets content. Render without it.
function renderSource(state: EditorState): string {
  const text = state.doc.toString()
  const sel = state.selection
  if (sel.ranges.length !== 1 || !sel.main.empty) return text
  const line = state.doc.lineAt(sel.main.head)
  const lead = /^(?:[ \t]*> ?)*[ \t]*/.exec(line.text)![0]
  const rest = line.text.slice(lead.length)
  if (sel.main.head !== line.to || !rest || !BARE_MARKER.test(rest) || inCodeBlock(text, line.number)) return text
  return text.slice(0, line.from + lead.length).replace(/[ \t]+$/, '') + text.slice(line.to)
}

export function create(textarea: HTMLTextAreaElement): EditorFacade {
  const host = document.createElement('div')
  host.className = 'carve-cm'
  textarea.after(host)
  textarea.hidden = true

  const wrapping = new Compartment()
  let wrap = textarea.getAttribute('wrap') !== 'off'
  const inputListeners: EventListener[] = []
  let lastRender = textarea.value
  let highlightTimer: ReturnType<typeof setTimeout> | undefined

  const syncGutterWidth = (v: EditorView): void => {
    const width = (v.dom.querySelector('.cm-gutters') as HTMLElement | null)?.offsetWidth ?? 0
    host.style.setProperty('--carve-gutter-w', `${width}px`)
  }
  const scheduleHighlight = (delay = 150): void => {
    clearTimeout(highlightTimer)
    highlightTimer = setTimeout(() => {
      const deco = tokenize(view.state.doc.toString())
      if (deco) view.dispatch({ effects: setTokens.of(deco) })
    }, delay)
  }

  const view: EditorView = new EditorView({
    parent: host,
    state: EditorState.create({
      doc: textarea.value,
      extensions: [
        lineNumbers(),
        highlightActiveLineGutter(),
        highlightSpecialChars(),
        history(),
        drawSelection(),
        highlightActiveLine(),
        highlightSelectionMatches(),
        keymap.of([
          { key: 'Enter', run: continueOnEnter },
          { key: 'Backspace', run: deleteBareMarker },
          { key: 'Tab', run: listIndent('indent', indentMore) },
          { key: 'Shift-Tab', run: listIndent('outdent', indentLess) },
          ...defaultKeymap,
          ...historyKeymap,
          ...searchKeymap,
        ]),
        wrapping.of(wrap ? EditorView.lineWrapping : []),
        EditorView.contentAttributes.of({ spellcheck: 'false', 'aria-label': 'Carve markup' }),
        tokenField,
        theme,
        EditorView.updateListener.of((u) => {
          if (u.geometryChanged) syncGutterWidth(u.view)
          const render = renderSource(u.state)
          const renderChanged = render !== lastRender
          lastRender = render
          if (u.docChanged) textarea.value = u.state.doc.toString()
          // Moving off an empty marker changes what renders without changing the text.
          if (u.docChanged || renderChanged) {
            const event = new Event('input')
            inputListeners.forEach((fn) => fn(event))
          }
          if (u.docChanged) scheduleHighlight()
        }),
      ],
    }),
  })
  syncGutterWidth(view)
  scheduleHighlight(0)
  if (!(globalThis as { CarveJS?: unknown }).CarveJS) {
    window.addEventListener('load', () => scheduleHighlight(0), { once: true })
  }

  const select = (anchor: number, head: number): void => {
    const len = view.state.doc.length
    view.dispatch({ selection: { anchor: Math.min(anchor, len), head: Math.min(head, len) } })
  }

  return {
    view,
    get value() {
      return view.state.doc.toString()
    },
    set value(next: string) {
      // Replace only the changed span, so undo and the cursor survive toolbar edits.
      const prev = view.state.doc.toString()
      if (prev === next) return
      let start = 0
      while (start < prev.length && start < next.length && prev[start] === next[start]) start++
      let endPrev = prev.length
      let endNext = next.length
      while (endPrev > start && endNext > start && prev[endPrev - 1] === next[endNext - 1]) {
        endPrev--
        endNext--
      }
      view.dispatch({ changes: { from: start, to: endPrev, insert: next.slice(start, endNext) } })
    },
    get selectionStart() {
      return view.state.selection.main.from
    },
    set selectionStart(n: number) {
      select(n, Math.max(n, view.state.selection.main.to))
    },
    get selectionEnd() {
      return view.state.selection.main.to
    },
    set selectionEnd(n: number) {
      select(Math.min(n, view.state.selection.main.from), n)
    },
    setSelectionRange(start: number, end: number) {
      select(start, end)
    },
    get scrollTop() {
      return view.scrollDOM.scrollTop
    },
    set scrollTop(n: number) {
      view.scrollDOM.scrollTop = n
    },
    get scrollHeight() {
      return view.scrollDOM.scrollHeight
    },
    get clientHeight() {
      return view.scrollDOM.clientHeight
    },
    get clientWidth() {
      return view.scrollDOM.clientWidth
    },
    focus: () => view.focus(),
    scrollIntoView: (options) => host.scrollIntoView(options),
    getAttribute(name) {
      return name === 'wrap' ? (wrap ? 'soft' : 'off') : textarea.getAttribute(name)
    },
    setAttribute(name, value) {
      if (name !== 'wrap') return textarea.setAttribute(name, value)
      wrap = value !== 'off'
      view.dispatch({ effects: wrapping.reconfigure(wrap ? EditorView.lineWrapping : []) })
    },
    addEventListener(type, listener, options) {
      if (type === 'input') inputListeners.push(listener)
      else if (type === 'scroll') view.scrollDOM.addEventListener(type, listener, options)
      else if (['keydown', 'keyup', 'click', 'focus'].includes(type)) view.contentDOM.addEventListener(type, listener, options)
      else view.dom.addEventListener(type, listener, options)
    },
    get renderValue() {
      return renderSource(view.state)
    },
    lineTops() {
      const docTop = view.documentTop - view.scrollDOM.getBoundingClientRect().top + view.scrollDOM.scrollTop
      const doc = view.state.doc
      const tops: number[] = []
      for (let i = 1; i <= doc.lines; i++) tops.push(docTop + view.lineBlockAt(doc.line(i).from).top)
      tops.push(docTop + view.lineBlockAt(doc.length).bottom)
      return tops
    },
  }
}
