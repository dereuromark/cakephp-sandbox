/**
 * Carve language definition for highlight.js
 *
 * Carve is a Djot-derived markup language with distinct inline delimiters:
 * emphasis is /text/ (not _text_), underline is _text_, strikethrough is
 * ~text~ (Djot uses ~ for subscript), subscript is ,,text,, and highlight is
 * ==text== (Djot uses {=text=}). Strong (*text*), superscript (^text^),
 * insert ({+text+}) and delete ({-text-}) match Djot.
 *
 * @see https://github.com/markup-carve/carve for the Carve specification
 */
(function() {
    function carve(hljs) {
        // Block attributes: {.class #id key=value} or boolean {reversed}
        // Excludes special inline syntax like {= {+ {- {%
        const ATTRIBUTE = {
            className: 'attr',
            begin: /\{(?![=+\-%])[^}]+\}/,
            relevance: 5,
        };

        // Frontmatter: YAML metadata at document start
        const FRONTMATTER = {
            className: 'meta',
            begin: /^---$/,
            end: /^---$/,
            relevance: 10,
        };

        // Headings: # to ######
        const HEADING = {
            className: 'section',
            begin: /^#{1,6}\s/,
            end: /$/,
            relevance: 10,
        };

        // Emphasis (Carve): /text/ - the begin guard avoids URLs and paths
        // (a/b, ://); the end is a closing slash not followed by word char/slash.
        const EMPHASIS = {
            className: 'emphasis',
            begin: /(?<![\w:/])\/(?=\S)/,
            end: /\/(?![\w/])/,
            relevance: 0,
        };

        // Underline (Carve): _text_ - not in the middle of words
        const UNDERLINE = {
            className: 'emphasis',
            begin: /(?<!\w)_(?!\s)/,
            end: /_(?!\w)/,
            relevance: 0,
        };

        // Strong: *text* - not in the middle of words, can contain emphasis.
        // Excludes *[ which is abbreviation-definition syntax.
        const STRONG = {
            className: 'strong',
            begin: /(?<!\w)\*(?![\s\[])/,
            end: /\*(?!\w)/,
            relevance: 0,
            contains: [EMPHASIS, UNDERLINE],
        };

        // Highlight (Carve): ==text==
        const HIGHLIGHT = {
            className: 'addition',
            begin: /==(?=\S)/,
            end: /==/,
            relevance: 3,
        };

        // Insert: {+text+}
        const INSERT = {
            className: 'addition',
            begin: /\{\+/,
            end: /\+\}/,
            relevance: 5,
        };

        // Delete: {-text-}
        const DELETE = {
            className: 'deletion',
            begin: /\{-/,
            end: /-\}/,
            relevance: 5,
        };

        // Strikethrough (Carve): ~text~ (Djot uses ~ for subscript instead)
        const STRIKETHROUGH = {
            className: 'deletion',
            begin: /(?<!\w)~(?=\S)/,
            end: /~(?!\w)/,
            relevance: 2,
        };

        // Subscript (Carve): ,,text,,
        const SUBSCRIPT = {
            className: 'built_in',
            begin: /,,(?=\S)/,
            end: /,,/,
            relevance: 3,
        };

        // Superscript: ^text^
        const SUPERSCRIPT = {
            className: 'built_in',
            begin: /\^(?!\s)/,
            end: /\^/,
            relevance: 2,
        };

        // Inline code: `code` or ``code``
        const INLINE_CODE = {
            className: 'code',
            begin: /`+/,
            end: /`+/,
            relevance: 0,
        };

        // Inline links: [text](url) with optional trailing attributes
        const LINK = {
            className: 'link',
            begin: /\[[^\]]*\]\([^)]*\)(\{[^}]+\})?/,
            relevance: 5,
        };

        // Autolinks: <https://...> or <mailto:...>
        const AUTOLINK = {
            className: 'link',
            begin: /<https?:\/\/[^>]+>/,
            relevance: 5,
        };

        // Email autolinks: <user@example.com>
        const EMAIL_AUTOLINK = {
            className: 'link',
            begin: /<[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}>/,
            relevance: 5,
        };

        // Images: ![alt](url) with optional trailing attributes
        const IMAGE = {
            className: 'link',
            begin: /!\[[^\]]*\]\([^)]*\)(\{[^}]+\})?/,
            relevance: 5,
        };

        // Reference links: [text][ref] with optional trailing attributes
        const REFERENCE_LINK = {
            className: 'link',
            begin: /\[[^\]]+\]\[[^\]]*\](\{[^}]+\})?/,
            relevance: 5,
        };

        // Spans with attributes: [text]{.class} or [text]{#id}
        const SPAN = {
            className: 'string',
            begin: /\[[^\]]+\]\{[^}]+\}/,
            relevance: 5,
        };

        // Reference definitions: [ref]: url
        const REFERENCE_DEF = {
            className: 'symbol',
            begin: /^\[[^\]^\]]+\]:/,
            end: /$/,
            relevance: 10,
        };

        // Footnote references: [^note]
        const FOOTNOTE_REF = {
            className: 'symbol',
            begin: /\[\^[^\]]+\]/,
            relevance: 5,
        };

        // Footnote definitions: [^note]: content
        const FOOTNOTE_DEF = {
            className: 'symbol',
            begin: /^\[\^[^\]]+\]:/,
            end: /$/,
            relevance: 10,
        };

        // Abbreviation definitions: *[ABBR]: text
        const ABBREVIATION_DEF = {
            className: 'symbol',
            begin: /^\*\[[^\]]+\]:/,
            end: /$/,
            relevance: 10,
        };

        // Blockquotes: > text
        const BLOCKQUOTE = {
            className: 'quote',
            begin: /^>/,
            end: /$/,
            relevance: 0,
        };

        // Horizontal rules: --- or *** or ___
        const HORIZONTAL_RULE = {
            className: 'meta',
            begin: /^(-{3,}|\*{3,}|_{3,})$/,
            relevance: 10,
        };

        // Bullet list items: - or *
        const LIST_BULLET = {
            className: 'bullet',
            begin: /^[ \t]*[-*](?=\s)/,
            relevance: 0,
        };

        // Numbered list items: decimal (1.), alpha (a. A.), roman (i. I.)
        const LIST_NUMBER = {
            className: 'bullet',
            begin: /^[ \t]*(\d+[.)]|[a-zA-Z][.)]|[ivxlcdmIVXLCDM]+[.)])(?=\s)/,
            relevance: 0,
        };

        // Task list items: - [ ] or - [x]
        const TASK_LIST = {
            className: 'bullet',
            begin: /^[ \t]*[-*]\s\[[ xX_]\]/,
            relevance: 5,
        };

        // Definition list terms: : term
        const DEFINITION_TERM = {
            className: 'title',
            begin: /^: /,
            end: /$/,
            relevance: 5,
        };

        // Code fence opening: ``` or ~~~ with optional language
        const CODE_FENCE_START = {
            className: 'keyword',
            begin: /^[`~]{3,}\s*[a-zA-Z]*$/,
            relevance: 10,
        };

        // Code fence closing: ``` or ~~~
        const CODE_FENCE_END = {
            className: 'keyword',
            begin: /^[`~]{3,}$/,
            relevance: 10,
        };

        // Div block opening: ::: with optional class
        const DIV_BLOCK_START = {
            className: 'keyword',
            begin: /^:{3,}\s*\w*$/,
            relevance: 10,
        };

        // Div block closing: :::
        const DIV_BLOCK_END = {
            className: 'keyword',
            begin: /^:{3,}$/,
            relevance: 10,
        };

        // Inline comments: {% comment %}
        const INLINE_COMMENT = {
            className: 'comment',
            begin: /\{%/,
            end: /%\}/,
            relevance: 5,
        };

        // Table separator: |---|---|
        const TABLE_SEPARATOR = {
            className: 'meta',
            begin: /^\|[-:| ]+\|$/,
            relevance: 5,
        };

        // Line blocks: | text (for poetry) - must precede TABLE_ROW
        const LINE_BLOCK = {
            className: 'string',
            begin: /^\| /,
            end: /$/,
            relevance: 3,
        };

        // Table rows: | cell | cell |
        const TABLE_ROW = {
            className: 'string',
            begin: /^\|/,
            end: /\|(\{[^}]*\})?$/,
            relevance: 2,
        };

        // Captions: ^ caption text
        const CAPTION = {
            className: 'title',
            begin: /^\^ /,
            end: /$/,
            relevance: 5,
        };

        // Raw format marker: {=html} or {=latex}
        const RAW_FORMAT = {
            className: 'meta',
            begin: /\{=[a-zA-Z]+\}/,
            relevance: 5,
        };

        // Escaped characters: \* \[ etc
        const ESCAPE = {
            className: 'symbol',
            begin: /\\[!"#$%&'()*+,.\/:;<=>?@\[\\\]^_`{|}~-]/,
            relevance: 0,
        };

        // Hard line break: \ at end of line
        const HARD_BREAK = {
            className: 'meta',
            begin: /\\$/,
            relevance: 2,
        };

        return {
            name: 'Carve',
            aliases: ['carve'],
            case_insensitive: false,
            contains: [
                // Block-level elements (order matters - more specific first)
                FRONTMATTER,       // Must be first (document start)
                HEADING,
                CODE_FENCE_START,
                CODE_FENCE_END,
                DIV_BLOCK_START,
                DIV_BLOCK_END,
                HORIZONTAL_RULE,
                TABLE_SEPARATOR,
                LINE_BLOCK,        // Must be before TABLE_ROW (both start with |)
                TABLE_ROW,
                BLOCKQUOTE,
                CAPTION,
                TASK_LIST,         // Must be before LIST_BULLET
                LIST_BULLET,
                LIST_NUMBER,
                DEFINITION_TERM,
                FOOTNOTE_DEF,      // Must be before REFERENCE_DEF
                ABBREVIATION_DEF,  // Must be before REFERENCE_DEF (*[ABBR]: vs [ref]:)
                REFERENCE_DEF,

                // Inline elements (order matters - more specific first)
                FOOTNOTE_REF,
                IMAGE,             // Must be before LINK (starts with !)
                SPAN,              // Must be before LINK ([text]{attr} vs [text](url))
                REFERENCE_LINK,    // Must be before LINK ([text][ref] vs [text](url))
                LINK,
                AUTOLINK,
                EMAIL_AUTOLINK,
                RAW_FORMAT,        // {=html} - must be before INSERT/DELETE braces
                INSERT,            // {+text+}
                DELETE,            // {-text-}
                INLINE_COMMENT,    // {% %} - must be before ATTRIBUTE
                HIGHLIGHT,         // ==text==
                SUBSCRIPT,         // ,,text,,
                SUPERSCRIPT,       // ^text^
                STRONG,
                EMPHASIS,          // /text/
                UNDERLINE,         // _text_
                STRIKETHROUGH,     // ~text~
                INLINE_CODE,
                ATTRIBUTE,
                ESCAPE,
                HARD_BREAK,
            ],
        };
    }

    // Register with highlight.js
    if (typeof hljs !== 'undefined') {
        hljs.registerLanguage('carve', carve);
    }

    // Export for module systems
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = carve;
    }
})();
