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
<?= $this->element('carve/package_styles') ?>
<style>
/* Local preview affordances. Construct styling comes from carve-css. */

.carve-rendered .highlight {
	background-color: #fff3cd;
	padding: 0.1em 0.3em;
	border-radius: 0.2em;
}

/* Language-aware {.diff} fences. The marker has its own column so copied code
   keeps the authored patch spelling while the code remains aligned. */
.carve-rendered pre.has-diff code {
	display: block;
}
.carve-rendered pre.has-diff .line {
	display: inline-block;
	width: 100%;
	min-height: 1lh;
}
.carve-rendered pre.has-diff .line.diff.add {
	background: rgba(46, 160, 67, 0.15);
}
.carve-rendered pre.has-diff .line.diff.remove {
	background: rgba(248, 81, 73, 0.15);
}
.carve-rendered pre.has-diff .diff-marker {
	display: inline-block;
	width: 1ch;
	font-weight: 700;
}
.carve-rendered pre.has-diff .line.diff.add .diff-marker {
	color: #1a7f37;
}
.carve-rendered pre.has-diff .line.diff.remove .diff-marker {
	color: #cf222e;
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

.carve-rendered figcaption::before {
	content: "— ";
}
.carve-rendered table caption {
	caption-side: bottom;
	font-style: italic;
	color: #666;
	font-size: 0.9em;
	text-align: left;
}
.carve-rendered div:is(.caution, .important):not(.admonition) {
	background: #f8d7da;
	border-left: 4px solid #dc3545;
	padding: 0.75em 1em;
	margin: 1em 0;
}
.carve-rendered .admonition:is(.caution, .important) {
	--carve-adm: #dc3545;
	--carve-adm-wash: #f8d7da;
}
.carve-rendered .admonition.example { --carve-adm: #6f42c1; --carve-adm-wash: #f3eaf9; }
.carve-rendered .admonition.quote { --carve-adm: #adb5bd; --carve-adm-wash: #e9ecef; }
.carve-rendered .swatch-chip-round,
.carve-rendered .swatch-chip-ring { border-radius: 50%; }
.carve-rendered .swatch-chip-ring { background: transparent; border-width: 2px; }
.carve-rendered .swatch-chip-only .swatch-chip { margin-right: 0; cursor: help; }
.carve-rendered .swatch-tint { padding: 0 0.25em; border-radius: 4px; }
.carve-rendered .swatch-label {
	display: inline-block;
	padding: 0.05em 0.45em;
	border-radius: 3px;
	font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
	font-size: 0.9em;
	border: 1px solid rgba(0, 0, 0, 0.15);
}
.carve-rendered kbd {
	background: #f8f9fa;
	border: 1px solid #dee2e6;
	border-radius: 3px;
	padding: 0.1em 0.35em;
	box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.1);
	color: #212529;
}
.carve-rendered dfn { font-style: italic; font-weight: 500; color: #0d6efd; }
.carve-rendered abbr[title] { text-decoration: underline dotted; cursor: help; }
:is(.carve-rendered, .html-output) img.carve-svg { max-width: 100%; height: auto; }

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
	border: 0;
	border-left: 3px solid #e0af68;
}
.carve-rendered span.spoiler {
	padding: 0 0.15em;
}
.carve-rendered span.spoiler:not(.revealed, .masked):hover { filter: blur(0.3em); }
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
