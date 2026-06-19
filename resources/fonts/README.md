# PDF core fonts

Standard PDF "core 14" font definitions consumed by the CakePdf `TcLibPdf`
engine (`tecnickcom/tc-lib-pdf`), which ships no fonts of its own. The
`K_PATH_FONTS` constant defined in `config/bootstrap.php` points here.

The metric data was generated from the URW base35 fonts (`fonts-urw-base35`,
metric-compatible with the standard PDF core fonts). The core 14 are referenced
by name and not embedded, so these files carry only font metrics and encoding
tables, no glyph outlines.
