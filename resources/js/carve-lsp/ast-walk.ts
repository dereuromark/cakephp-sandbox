/**
 * Walks every node of a parsed Carve document, parents before children.
 *
 * Blocks do not all hang off `children`: list items sit in `items`, a
 * description list's bodies in `items[].definitions`, and footnote bodies in
 * the document's `footnoteDefs`. A walker that follows `children` alone sees
 * only some of them, so this one descends into every property except `pos`
 * and `attrs`.
 */

export interface AstNode {
  type?: string
  pos?: { startLine?: number; startColumn?: number; endLine?: number; endColumn?: number; startOffset?: number; endOffset?: number }
  children?: unknown
  [key: string]: unknown
}

/** Return `false` from `visit` to skip the node's subtree. `ancestors` holds the enclosing typed nodes, outermost first. */
export function walkNodes(root: unknown, visit: (node: AstNode, ancestors: readonly AstNode[]) => boolean | void): void {
  const ancestors: AstNode[] = []
  const walk = (value: unknown): void => {
    if (Array.isArray(value)) { for (const child of value) walk(child); return }
    if (!value || typeof value !== 'object') return
    const node = value as AstNode
    const typed = typeof node.type === 'string'
    if (typed && visit(node, ancestors) === false) return
    if (typed) ancestors.push(node)
    for (const [name, child] of Object.entries(node)) if (name !== 'pos' && name !== 'attrs') walk(child)
    if (typed) ancestors.pop()
  }
  walk(root)
}
