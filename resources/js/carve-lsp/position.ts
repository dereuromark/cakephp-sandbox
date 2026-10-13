import { parse } from '@markup-carve/carve'

/**
 * Converts between the units Carve positions and LSP positions count.
 *
 * A Carve AST position counts UNICODE CODEPOINTS (spec PART 12 §4, chosen so
 * an index always lands on a character boundary). An LSP position counts
 * UTF-16 code units unless the client and server negotiate `positionEncoding`,
 * which this server does not do, so UTF-16 is what every client here expects.
 *
 * The two units agree on the entire BMP and diverge on every astral character:
 * one emoji earlier in the line shifts every LSP column after it by one. So a
 * position read off the AST cannot be handed to a client, nor a position from
 * a client compared against the AST, without passing through here.
 */

/**
 * A 1-based codepoint column, as an AST position reports it, to the 0-based
 * UTF-16 character an LSP range carries.
 */
export function codepointColumnToUtf16(lineText: string, column: number): number {
  if (column <= 1) return 0

  let codepointColumn = 1
  let index = 0
  while (index < lineText.length && codepointColumn < column) {
    index += (lineText.codePointAt(index) ?? 0) > 0xffff ? 2 : 1
    codepointColumn++
  }

  // A column past the line's last character is normal: end columns are
  // exclusive, so a construct ending the line reports length + 1. Anything
  // further past the end keeps its distance rather than collapsing onto it,
  // so a range can never come back inverted.
  return index + Math.max(0, column - codepointColumn)
}

/**
 * The 0-based UTF-16 character an LSP request carries, to the 1-based codepoint
 * column an AST position can be compared against.
 *
 * A character index pointing into the middle of a surrogate pair resolves to
 * the column after that pair. There is no column for half a character, and a
 * client only produces one by placing a cursor inside one.
 */
export function utf16CharToCodepointColumn(lineText: string, character: number): number {
  let codepointColumn = 1
  let index = 0
  while (index < lineText.length && index < character) {
    index += (lineText.codePointAt(index) ?? 0) > 0xffff ? 2 : 1
    codepointColumn++
  }

  return codepointColumn + Math.max(0, character - index)
}

/**
 * The document's lines, line endings normalized, indexed 0-based - the form
 * both conversions above need to see a line's characters.
 */
export function sourceLines(source: string): string[] {
  return source.replace(/\r\n?/g, '\n').split('\n')
}

/**
 * Which unit the installed parser's columns are in.
 *
 * This is not a constant, because the dependency range spans both answers.
 * Positions arrived in @markup-carve/carve counting UTF-16 code units, which
 * is what a JavaScript string is indexed by; carve-js#447 then made them count
 * codepoints, to conform to the spec. Both satisfy `^0.1.2`, so a build of this
 * server installed today and the same build installed after that release are
 * handed different numbers for the same document, and nothing in the package
 * metadata distinguishes them.
 *
 * Rather than guess, ask: one astral character is two UTF-16 code units and one
 * codepoint, so a two-character probe reports a different end column under each
 * unit. The answer is cached - it cannot change within a process.
 */
// Exported so the guard test drives THE PROBE rather than a copy of it. A test
// that retypes the probe string agrees with this function for every value the
// engine can return, including `undefined`, and goes on agreeing after the
// probe here is changed to something that cannot tell the two units apart -
// which is the whole failure it is supposed to report.
export const COLUMN_PROBE = '\u{1F600}x'
export const CODEPOINT_PROBE_END_COLUMN = 3
let cachedUnit: 'codepoint' | 'utf16' | undefined

/**
 * The raw reading the classification is made from: the probe's end column as
 * the installed parser reports it, or `undefined` when the parser cannot answer
 * at all.
 *
 * Split out and exported so the guard test can consume THE READING the
 * classifier uses, instead of computing its own copy of it. A test that reparses
 * the probe itself agrees with `engineColumnUnit` for every value including
 * `undefined`, so it cannot see the difference between a measurement and the
 * fallback below - which is the only thing worth checking here.
 */
export function probeEndColumn(): number | undefined {
  try {
    return parse(COLUMN_PROBE).children[0]?.pos?.endColumn
  } catch {
    return undefined
  }
}

export function engineColumnUnit(): 'codepoint' | 'utf16' {
  if (cachedUnit) return cachedUnit

  // A parser that cannot answer gets the reading that needs no conversion,
  // which is what every released version has done so far. That default is right
  // for a server that must not crash on an unexpected engine, and wrong to
  // accept silently in CI, so a test asserts the probe was actually answered.
  const endColumn = probeEndColumn()
  cachedUnit = endColumn === CODEPOINT_PROBE_END_COLUMN ? 'codepoint' : 'utf16'

  return cachedUnit
}

/**
 * Test seam: pin the unit, or pass `undefined` to probe again.
 *
 * The installed parser can only demonstrate one of the two readings, and it is
 * the one whose conversion is the identity - so without this the codepoint
 * branch would ship untested and unrun until a dependency bump made it live.
 */
export function setEngineColumnUnit(unit: 'codepoint' | 'utf16' | undefined): void {
  cachedUnit = unit
}

/**
 * A 1-based column as the installed parser reports it, to the 0-based UTF-16
 * character an LSP range carries. Use this rather than the raw conversion:
 * under a UTF-16 parser the columns already are LSP characters, and converting
 * them would introduce the very shift it is meant to remove.
 */
export function astColumnToCharacter(lineText: string, column: number): number {
  return engineColumnUnit() === 'codepoint' ? codepointColumnToUtf16(lineText, column) : column - 1
}

/**
 * The 0-based UTF-16 character an LSP request carries, to the 1-based column
 * the installed parser's positions can be compared against.
 */
export function characterToAstColumn(lineText: string, character: number): number {
  return engineColumnUnit() === 'codepoint' ? utf16CharToCodepointColumn(lineText, character) : character + 1
}

/**
 * An OFFSET as the installed parser reports it, to the index a JavaScript
 * string is sliced by.
 *
 * The same divergence as the column pair above, one axis over: an offset into
 * the whole document rather than into a line. It is the conversion a position
 * computed by slicing the source needs, and only for offsets the PARSER
 * produced - `djotMigrationWarnings` reports UTF-16 offsets, and passing one
 * through here would move it.
 */
export function astOffsetToIndex(source: string, offset: number): number {
  if (engineColumnUnit() !== 'codepoint') return offset

  let index = 0
  let counted = 0
  while (index < source.length && counted < offset) {
    index += (source.codePointAt(index) ?? 0) > 0xffff ? 2 : 1
    counted += 1
  }

  // An offset past the end keeps its distance rather than collapsing onto it,
  // for the same reason the column conversion does: an end offset is exclusive.
  return index + Math.max(0, offset - counted)
}
