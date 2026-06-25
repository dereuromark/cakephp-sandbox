<?php
/**
 * Shared styles for rendered Carve HTML output.
 *
 * Add the `carve-rendered` class to any container that holds Carve-converted
 * HTML (the live playground, roundtrip preview, interruption panes, ...) and
 * include this element once on the page:
 *
 *     <?= $this->element('carve/output_styles') ?>
 *
 * @var \App\View\AppView $this
 */
?>
<style>
/*
 * Task lists. Carve emits a plain <ul><li><input type="checkbox"> with no
 * task-list class (unlike Djot), so target the checkbox structurally: drop the
 * bullet only on items that contain a checkbox, and pull the box into the
 * gutter. Regular items in the same list keep their marker.
 */
.carve-rendered li:has(> input[type="checkbox"]) {
	list-style: none;
	position: relative;
	padding-left: 0.25em;
}
.carve-rendered li > input[type="checkbox"] {
	position: absolute;
	left: -1.3em;
	top: 0.3em;
	margin: 0;
}
/*
 * Admonitions. Carve renders the eight canonical types
 * (note, tip, warning, danger, info, success, example, quote) as a semantic
 * <aside class="admonition {type}"> and any other custom type as a generic
 * <div class="{type}">. Selectors are class-only so both elements match;
 * caution/important are covered as Tier-2 <div> aliases.
 */
.carve-rendered .warning,
.carve-rendered .note,
.carve-rendered .info,
.carve-rendered .tip,
.carve-rendered .caution,
.carve-rendered .important,
.carve-rendered .danger,
.carve-rendered .success,
.carve-rendered .example,
.carve-rendered .quote {
	padding: 1rem;
	margin: 1rem 0;
	border-radius: 0.25rem;
	border-left: 4px solid;
}
.carve-rendered .warning {
	background-color: #fff3cd;
	border-color: #ffc107;
}
.carve-rendered .note,
.carve-rendered .info {
	background-color: #cff4fc;
	border-color: #0dcaf0;
}
.carve-rendered .tip,
.carve-rendered .success {
	background-color: #d1e7dd;
	border-color: #198754;
}
.carve-rendered .caution,
.carve-rendered .important,
.carve-rendered .danger {
	background-color: #f8d7da;
	border-color: #dc3545;
}
.carve-rendered .example {
	background-color: #e2e3e5;
	border-color: #6c757d;
}
.carve-rendered .quote {
	background-color: #e9ecef;
	border-color: #adb5bd;
}
.carve-rendered .admonition-title {
	font-weight: 600;
	margin-bottom: 0.5rem;
}
.carve-rendered .warning > *:first-child,
.carve-rendered .note > *:first-child,
.carve-rendered .info > *:first-child,
.carve-rendered .tip > *:first-child,
.carve-rendered .caution > *:first-child,
.carve-rendered .important > *:first-child,
.carve-rendered .danger > *:first-child,
.carve-rendered .success > *:first-child,
.carve-rendered .example > *:first-child,
.carve-rendered .quote > *:first-child {
	margin-top: 0;
}
.carve-rendered .warning > *:last-child,
.carve-rendered .note > *:last-child,
.carve-rendered .info > *:last-child,
.carve-rendered .tip > *:last-child,
.carve-rendered .caution > *:last-child,
.carve-rendered .important > *:last-child,
.carve-rendered .danger > *:last-child,
.carve-rendered .success > *:last-child,
.carve-rendered .example > *:last-child,
.carve-rendered .quote > *:last-child {
	margin-bottom: 0;
}
.carve-rendered .highlight {
	background-color: #fff3cd;
	padding: 0.1em 0.3em;
	border-radius: 0.2em;
}
.carve-rendered .term {
	font-style: italic;
	border-bottom: 1px dotted #666;
}
.carve-rendered ins {
	color: #0f5132;
	background-color: #d1e7dd;
	text-decoration: none;
	padding: 0.05em 0.25em;
	border-radius: 0.2em;
}
.carve-rendered del {
	color: #842029;
	background-color: #f8d7da;
	text-decoration: line-through;
	padding: 0.05em 0.25em;
	border-radius: 0.2em;
}
.carve-rendered .class1 {
	color: #0d6efd;
}
.carve-rendered .class2 {
	font-weight: bold;
}
.carve-rendered span[id] {
	background-color: #e7f1ff;
	padding: 0.1em 0.2em;
	border-radius: 0.2em;
}
.carve-rendered div.line-block {
	padding-left: 1em;
	border-left: 3px solid #dee2e6;
}
.carve-rendered dl {
	width: auto;
	line-height: 1.5em;
}
.carve-rendered dt {
	font-weight: bold;
	width: auto;
	margin-top: 0.5em;
}
.carve-rendered dd {
	margin-left: 1.5em;
	margin-top: 0;
}
.carve-rendered figure {
	margin: 1em 0;
	padding: 0;
}
.carve-rendered figure blockquote {
	margin-bottom: 0.5em;
}
.carve-rendered figcaption {
	font-style: italic;
	color: #666;
	font-size: 0.9em;
	padding-left: 1em;
}
.carve-rendered figcaption::before {
	content: "— ";
}
.carve-rendered table {
	width: 100%;
	margin-bottom: 1rem;
	color: #212529;
	border-collapse: collapse;
}
.carve-rendered table th,
.carve-rendered table td {
	padding: 0.5rem;
	border: 1px solid #dee2e6;
	vertical-align: top;
	text-align: left;
}
.carve-rendered table thead th {
	border-bottom: 2px solid #dee2e6;
	background-color: #f8f9fa;
}
/* list-table cells can hold block content; drop stray outer margins */
.carve-rendered table td > :first-child,
.carve-rendered table th > :first-child {
	margin-top: 0;
}
.carve-rendered table td > :last-child,
.carve-rendered table th > :last-child {
	margin-bottom: 0;
}
.carve-rendered table caption {
	caption-side: bottom;
	font-style: italic;
	color: #666;
	font-size: 0.9em;
	padding-top: 0.5em;
	text-align: left;
}
/* SpoilerExtension: blurred until CLICKED (JS toggles .revealed); details is native */
.carve-rendered span.spoiler,
.carve-rendered div.spoiler {
	filter: blur(0.3em);
	cursor: pointer;
	border-radius: 3px;
	background-color: rgba(127, 127, 127, 0.14);
	user-select: none;
	-webkit-user-select: none;
	transition: filter 0.2s;
	outline-offset: 3px;
}
.carve-rendered div.spoiler {
	display: block;
	filter: blur(0.4em);
	padding: 0.6rem 0.9rem;
	border-left: 3px solid #e0af68;
}
.carve-rendered span.spoiler {
	padding: 0 0.15em;
}
.carve-rendered span.spoiler.revealed,
.carve-rendered div.spoiler.revealed {
	filter: none;
	background-color: transparent;
	user-select: text;
	-webkit-user-select: text;
	cursor: auto;
}
.carve-rendered span.spoiler:focus-visible,
.carve-rendered div.spoiler:focus-visible {
	outline: 2px solid #0d6efd;
}
/* masked variant ({.masked}): every char a dot until revealed */
.carve-rendered span.spoiler.masked {
	filter: none;
	-webkit-text-security: disc;
	text-security: disc;
	letter-spacing: 0.08em;
}
.carve-rendered span.spoiler.masked.revealed {
	-webkit-text-security: none;
	text-security: none;
}
.carve-rendered details.spoiler {
	border: 1px solid #5a4a2a;
	border-left: 4px solid #e0af68;
	border-radius: 8px;
	padding: 0.4rem 0.9rem;
	background-color: #fdf8ee;
}
.carve-rendered details.spoiler > summary {
	cursor: pointer;
	font-weight: 600;
	list-style: none;
	user-select: none;
	-webkit-user-select: none;
}
.carve-rendered details.spoiler > summary::-webkit-details-marker {
	display: none;
}
.carve-rendered details.spoiler > summary::before {
	content: "\1F441  ";
}
.carve-rendered details.spoiler > summary::after {
	content: "  (click to reveal)";
	font-weight: 400;
	color: #6c757d;
}
.carve-rendered details.spoiler[open] > summary::after {
	content: "";
}
.carve-rendered details.spoiler[open] > summary {
	margin-bottom: 0.5rem;
}
/* ColorSwatchExtension: inline color chip + shape / tint options */
.carve-rendered .swatch-chip {
	display: inline-block;
	width: 0.9em;
	height: 0.9em;
	margin-right: 0.15em;
	border: 1px solid rgba(0, 0, 0, 0.2);
	border-radius: 3px;
	vertical-align: -0.1em;
}
.carve-rendered .swatch-chip-round {
	border-radius: 50%;
}
.carve-rendered .swatch-chip-ring {
	background: transparent;
	border-width: 2px;
	border-radius: 50%;
}
.carve-rendered .swatch-chip-only .swatch-chip {
	margin-right: 0;
	cursor: help;
}
.carve-rendered .swatch-tint {
	padding: 0 0.25em;
	border-radius: 4px;
}
/* GlossaryExtension: term use */
.carve-rendered .term {
	border-bottom: 1px dotted #6c757d;
	cursor: help;
}
/* SemanticSpanExtension: kbd / dfn / abbr */
.carve-rendered kbd {
	background-color: #f8f9fa;
	border: 1px solid #dee2e6;
	border-radius: 3px;
	padding: 0.1em 0.4em;
	font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
	font-size: 0.9em;
	box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.1);
	color: #212529;
}
.carve-rendered dfn {
	font-style: italic;
	font-weight: 500;
	color: #0d6efd;
}
.carve-rendered abbr[title] {
	text-decoration: underline dotted;
	cursor: help;
}
/* WikilinksExtension */
.carve-rendered .wikilink {
	color: #0969da;
	text-decoration: none;
	border-bottom: 1px dashed #0969da;
}
.carve-rendered .wikilink:hover {
	border-bottom-style: solid;
}
/* InlineFootnotesExtension */
.carve-rendered a[role="doc-noteref"] {
	text-decoration: none;
	font-weight: 600;
}
.carve-rendered section[role="doc-endnotes"] {
	margin-top: 1.5rem;
	padding-top: 0.5rem;
	font-size: 0.9em;
	color: #495057;
}
.carve-rendered section[role="doc-endnotes"] hr {
	border: none;
	border-top: 1px solid #dee2e6;
	margin: 0 0 0.75rem;
}
.carve-rendered a[role="doc-backlink"] {
	text-decoration: none;
	margin-left: 0.25em;
}
/* External links (ExternalLinksExtension) get an outbound marker */
.carve-rendered a[target="_blank"]::after {
	content: " \f1c5";
	font-family: "bootstrap-icons";
	font-size: 0.75em;
	vertical-align: super;
}

/* Code-fence pill: hover shows the language + a copy button in the top-right
   corner. Decoration wired by carveDecorateCodeBlocks (below). Applies to both
   the live .carve-rendered panes and the extensions page's .html-output (which
   holds the code-group panels). */
:is(.carve-rendered, .html-output) pre[data-pill] {
	position: relative;
}
:is(.carve-rendered, .html-output) .code-pill {
	position: absolute;
	top: 6px;
	right: 8px;
	display: flex;
	align-items: center;
	gap: 6px;
	opacity: 0;
	transition: opacity 0.15s;
	font-size: 12px;
	line-height: 1.4;
}
:is(.carve-rendered, .html-output) pre[data-pill]:hover .code-pill,
:is(.carve-rendered, .html-output) .code-pill:focus-within {
	opacity: 1;
}
:is(.carve-rendered, .html-output) .code-pill-lang {
	background: rgba(127, 127, 127, 0.2);
	color: #6c757d;
	padding: 1px 8px;
	border-radius: 999px;
}
:is(.carve-rendered, .html-output) .code-pill-copy {
	cursor: pointer;
	border: 1px solid #ced4da;
	background: #fff;
	border-radius: 6px;
	padding: 0 5px;
	font-size: 12px;
	line-height: 1.4;
}
:is(.carve-rendered, .html-output) .code-pill-copy:hover {
	border-color: #0d6efd;
}
</style>
<script>
/*
 * Code-fence pill wiring, shared by every page that renders Carve output.
 * On hover each highlighted code block shows its language + a click-to-copy
 * button in the top-right corner. Exposed as window.carveDecorateCodeBlocks so
 * the live playground can re-run it after a re-render; also auto-runs on load
 * and observes each .carve-rendered pane for dynamically inserted output.
 */
(function () {
	function decorate(container) {
		for (const pre of container.querySelectorAll('pre')) {
			if (pre.dataset.pill) continue;
			const code = pre.querySelector('code');
			if (!code) continue;
			const cls = [...code.classList].find(c => c.startsWith('language-'));
			const lang = cls ? cls.slice('language-'.length) : '';
			if (!lang || lang === 'mermaid') continue;
			pre.dataset.pill = 'true';
			const pill = document.createElement('div');
			pill.className = 'code-pill';
			const label = document.createElement('span');
			label.className = 'code-pill-lang';
			label.textContent = lang;
			const btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'code-pill-copy';
			btn.setAttribute('aria-label', 'Copy code');
			btn.textContent = '\u{1F4CB}';
			btn.addEventListener('click', () => {
				navigator.clipboard?.writeText(code.textContent || '').then(() => {
					btn.textContent = '✓';
					setTimeout(() => { btn.textContent = '\u{1F4CB}'; }, 1200);
				});
			});
			pill.append(label, btn);
			pre.appendChild(pill);
		}
	}
	window.carveDecorateCodeBlocks = decorate;
	function wire() {
		for (const pane of document.querySelectorAll('.carve-rendered, .html-output')) {
			decorate(pane);
			new MutationObserver(() => decorate(pane))
				.observe(pane, { childList: true, subtree: true });
		}
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', wire);
	} else {
		wire();
	}
})();
</script>
