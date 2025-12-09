/**
 * Djot language definition for highlight.js
 *
 * Supports the full Djot specification plus djot-php enhancements.
 * @see https://djot.net for Djot specification
 * @see https://github.com/php-collective/djot-php for enhancements
 */
(function() {
    function djot(hljs) {
        // Block attributes: {.class #id key=value} or boolean {reversed}
        // Excludes special syntax like {= {+ {- {%
        const ATTRIBUTE = {
            className: 'attr',
            begin: /\{(?![=+\-%])[^}]+\}/,
            relevance: 5,
        };

        // Headings: # to ######
        const HEADING = {
            className: 'section',
            begin: /^#{1,6}\s/,
            end: /$/,
            relevance: 10,
        };

        // Strong: *text*
        const STRONG = {
            className: 'strong',
            begin: /\*(?!\s)/,
            end: /\*/,
            relevance: 0,
        };

        // Emphasis: _text_
        const EMPHASIS = {
            className: 'emphasis',
            begin: /_(?!\s)/,
            end: /_/,
            relevance: 0,
        };

        // Highlight: {=text=}
        const HIGHLIGHT = {
            className: 'addition',
            begin: /\{=/,
            end: /=\}/,
            relevance: 5,
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

        // Superscript: ^text^
        const SUPERSCRIPT = {
            className: 'built_in',
            begin: /\^(?!\s)/,
            end: /\^/,
            relevance: 2,
        };

        // Subscript: ~text~
        const SUBSCRIPT = {
            className: 'built_in',
            begin: /~(?!\s)/,
            end: /~/,
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

        // Bullet list items: - or * or +
        const LIST_BULLET = {
            className: 'bullet',
            begin: /^[ \t]*[-*+](?=\s)/,
            relevance: 0,
        };

        // Numbered list items: 1. or 1)
        const LIST_NUMBER = {
            className: 'bullet',
            begin: /^[ \t]*\d+[.)](?=\s)/,
            relevance: 0,
        };

        // Task list items: - [ ] or - [x]
        const TASK_LIST = {
            className: 'bullet',
            begin: /^[ \t]*[-*+]\s\[[ xX]\]/,
            relevance: 5,
        };

        // Definition list terms: : term (at start of line with content after colon+space)
        const DEFINITION_TERM = {
            className: 'title',
            begin: /^: /,
            end: /$/,
            relevance: 5,
        };

        // Code fence opening: ``` with optional language or =format
        const CODE_FENCE_START = {
            className: 'keyword',
            begin: /^`{3,}\s*=?[a-zA-Z]*$/,
            relevance: 10,
        };

        // Code fence closing: ```
        const CODE_FENCE_END = {
            className: 'keyword',
            begin: /^`{3,}$/,
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

        // Fenced comment opening (djot-php extension): %%%
        const FENCED_COMMENT_START = {
            className: 'comment',
            begin: /^%{3,}$/,
            relevance: 10,
        };

        // Fenced comment closing: %%%
        const FENCED_COMMENT_END = {
            className: 'comment',
            begin: /^%{3,}$/,
            relevance: 10,
        };

        // Inline comments: {% comment %}
        const INLINE_COMMENT = {
            className: 'comment',
            begin: /\{%/,
            end: /%\}/,
            relevance: 5,
        };

        // Table rows: | cell | cell |
        const TABLE_ROW = {
            className: 'string',
            begin: /^\|/,
            end: /\|(\{[^}]*\})?$/,
            relevance: 2,
        };

        // Table separator: |---|---|
        const TABLE_SEPARATOR = {
            className: 'meta',
            begin: /^\|[-:| ]+\|$/,
            relevance: 5,
        };

        // Line blocks: | text (for poetry)
        const LINE_BLOCK = {
            className: 'string',
            begin: /^\| /,
            end: /$/,
            relevance: 3,
        };

        // Captions (djot-php extension): ^ caption text
        const CAPTION = {
            className: 'title',
            begin: /^\^ /,
            end: /$/,
            relevance: 5,
        };

        // Symbols: :name:
        const SYMBOL = {
            className: 'symbol',
            begin: /:[a-zA-Z_][a-zA-Z0-9_]*:/,
            relevance: 3,
        };

        // Inline math: $`code`$
        const INLINE_MATH = {
            className: 'formula',
            begin: /\$`/,
            end: /`\$/,
            relevance: 5,
        };

        // Display math: $$`code`$$
        const DISPLAY_MATH = {
            className: 'formula',
            begin: /\$\$`/,
            end: /`\$\$/,
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
            name: 'Djot',
            aliases: ['djot'],
            case_insensitive: false,
            contains: [
                // Block-level elements (order matters - more specific first)
                HEADING,
                CODE_FENCE_START,
                CODE_FENCE_END,
                DIV_BLOCK_START,
                DIV_BLOCK_END,
                FENCED_COMMENT_START,
                FENCED_COMMENT_END,
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
                REFERENCE_DEF,

                // Inline elements (order matters - more specific first)
                FOOTNOTE_REF,
                IMAGE,             // Must be before LINK (starts with !)
                SPAN,              // Must be before LINK ([text]{attr} vs [text](url))
                REFERENCE_LINK,    // Must be before LINK ([text][ref] vs [text](url))
                LINK,
                AUTOLINK,
                EMAIL_AUTOLINK,
                DISPLAY_MATH,      // Must be before INLINE_MATH ($$` vs $`)
                INLINE_MATH,
                RAW_FORMAT,        // {=html} - must be before HIGHLIGHT
                HIGHLIGHT,         // {=text=}
                INSERT,            // {+text+}
                DELETE,            // {-text-}
                INLINE_COMMENT,    // {% %} - must be before ATTRIBUTE
                SUPERSCRIPT,
                SUBSCRIPT,
                STRONG,
                EMPHASIS,
                INLINE_CODE,
                SYMBOL,
                ATTRIBUTE,
                ESCAPE,
                HARD_BREAK,
            ],
        };
    }

    // Register with highlight.js
    if (typeof hljs !== 'undefined') {
        hljs.registerLanguage('djot', djot);
    }

    // Export for module systems
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = djot;
    }
})();
