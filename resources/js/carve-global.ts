// Stands in for `@markup-carve/carve` in the editor bundle: the page already loads the
// engine as the `CarveJS` global (webroot/js/carve-js.min.js), so it is not bundled twice.
// Until that script has run, parse throws and the list helpers fall back to doing nothing.
export type Position = { startLine?: number; endLine?: number; startColumn?: number; endColumn?: number }

export function parse(source: string, options?: Record<string, unknown>): unknown {
  const engine = (globalThis as { CarveJS?: { parse: (s: string, o?: Record<string, unknown>) => unknown } }).CarveJS
  if (!engine) throw new Error('CarveJS is not loaded')
  return engine.parse(source, options)
}

export function carveToHtml(source: string, options?: Record<string, unknown>): string {
  const engine = (globalThis as { CarveJS?: { carveToHtml: (s: string, o?: Record<string, unknown>) => string } }).CarveJS
  if (!engine) throw new Error('CarveJS is not loaded')
  return engine.carveToHtml(source, options)
}
