// Sandbox stand-in for carve-lsp src/engine.ts: only the names the copied modules use.
// The editor bundle aliases @markup-carve/carve to ../carve-global.ts.
export { parse, parseWithDiagnostics, render, lint, stringOffsetOfByte } from '@markup-carve/carve'
export type { Position } from '@markup-carve/carve'
