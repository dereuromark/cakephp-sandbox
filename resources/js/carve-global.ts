// Stands in for `@markup-carve/carve` in the editor bundle: the page already loads the
// engine as the `CarveJS` global (webroot/js/carve-js.min.js), so it is not bundled twice.
// Until that script has run, every call throws and the list helpers fall back to doing nothing.
import type * as Carve from '@markup-carve/carve'

export type { Position } from '@markup-carve/carve'

function engine(): typeof Carve {
  const global = (globalThis as { CarveJS?: typeof Carve }).CarveJS
  if (!global) throw new Error('CarveJS is not loaded')
  return global
}

export const parse: typeof Carve.parse = (...args) => engine().parse(...args)
export const parseWithDiagnostics: typeof Carve.parseWithDiagnostics = (...args) => engine().parseWithDiagnostics(...args)
export const render: typeof Carve.render = (...args) => engine().render(...args)
export const lint: typeof Carve.lint = (...args) => engine().lint(...args)
export const stringOffsetOfByte: typeof Carve.stringOffsetOfByte = (...args) => engine().stringOffsetOfByte(...args)
