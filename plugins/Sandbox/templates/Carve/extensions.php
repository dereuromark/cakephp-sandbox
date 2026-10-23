<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array<string, mixed>> $examples
 */

$this->append('script');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/github.min.css');
echo $this->Html->css('Sandbox.highlighting/hljs-carve.css', ['timestamp' => 'force']);
echo $this->Html->css('https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.css');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-carve.js');
echo $this->Html->script('Sandbox.hljs-carve-delimited.js');
?>
<script type="module">
import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.esm.min.mjs';
import renderMathInElement from 'https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/contrib/auto-render.mjs';
import Chart from 'https://cdn.jsdelivr.net/npm/chart.js@4.4.6/auto/+esm';
mermaid.initialize({ startOnLoad: false, theme: 'default' });
// Render ```chart blocks (FencedRenderExtension text mode): <pre class="chart">
// holds the Chart.js JSON config as escaped text; parse it and draw a canvas.
window.chartRender = function(container) {
	for (const el of container.querySelectorAll('pre.chart')) {
		if (el.dataset.processed) continue;
		el.dataset.processed = 'true';
		let config;
		try {
			config = JSON.parse(el.textContent);
		} catch (e) {
			const err = document.createElement('div');
			err.className = 'alert alert-danger';
			err.textContent = 'Chart JSON error: ' + e.message;
			el.replaceWith(err);
			continue;
		}
		const wrap = document.createElement('div');
		wrap.style.maxWidth = '480px';
		const canvas = document.createElement('canvas');
		wrap.appendChild(canvas);
		el.replaceWith(wrap);
		try {
			new Chart(canvas, config);
		} catch (e) {
			const err = document.createElement('div');
			err.className = 'alert alert-danger';
			err.textContent = 'Chart error: ' + e.message;
			wrap.replaceWith(err);
		}
	}
};
// SpoilerExtension: click (or Enter/Space) to reveal blurred inline/div spoilers.
// details.spoiler is a native <details> and toggles itself, no JS needed.
window.spoilerWire = function(container) {
	for (const el of container.querySelectorAll('span.spoiler, div.spoiler')) {
		if (el.dataset.spoilerWired) continue;
		el.dataset.spoilerWired = 'true';
		el.tabIndex = 0;
		el.setAttribute('role', 'button');
		el.setAttribute('aria-label', 'Spoiler, activate to reveal');
		const sync = () => {
			const revealed = el.classList.contains('revealed');
			el.title = revealed ? 'Click to hide' : 'Click to reveal';
			el.setAttribute('aria-expanded', revealed ? 'true' : 'false');
		};
		sync();
		const toggle = () => { el.classList.toggle('revealed'); sync(); };
		el.addEventListener('click', toggle);
		el.addEventListener('keydown', (e) => {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				toggle();
			}
		});
	}
};
// Render inline ($...$) and block (\[...\], ```math) math via KaTeX.
window.mathRender = function(container) {
	try {
		renderMathInElement(container, {
			delimiters: [
				{ left: '$$', right: '$$', display: true },
				{ left: '\\[', right: '\\]', display: true },
				{ left: '$', right: '$', display: false },
				{ left: '\\(', right: '\\)', display: false },
			],
			throwOnError: false,
		});
	} catch (e) {
		// Leave the raw \[...\] text in place if KaTeX fails.
	}
};
window.mermaidRender = async function(container) {
	const diagrams = container.querySelectorAll('.mermaid');
	for (const el of diagrams) {
		if (el.dataset.processed) continue;
		el.dataset.processed = 'true';
		const id = 'mermaid-' + Math.random().toString(36).substr(2, 9);
		try {
			const { svg } = await mermaid.render(id, el.textContent);
			el.innerHTML = svg;
		} catch (e) {
			const errBox = document.createElement('div');
			errBox.className = 'alert alert-danger';
			errBox.textContent = 'Mermaid error: ' + e.message;
			el.replaceChildren(errBox);
		}
	}
};
// PlantUML (FencedRenderExtension::plantuml()): <pre class="plantuml"> holds the
// diagram source. Mermaid has no equivalent for Salt GUI mockups or full
// deployment/component UML, so this renders via the Kroki service - deflate the
// source, base64url it, and load the SVG. pako is imported lazily so the page
// only pays for it when a PlantUML block is on screen.
let pakoPromise = null;
function loadPako() {
	if (!pakoPromise) {
		pakoPromise = import('https://cdn.jsdelivr.net/npm/pako@2.1.0/+esm');
	}
	return pakoPromise;
}
function krokiEncode(pako, source) {
	const bytes = pako.deflate(new TextEncoder().encode(source), { level: 9 });
	let bin = '';
	for (const b of bytes) bin += String.fromCharCode(b);
	return btoa(bin).replace(/\+/g, '-').replace(/\//g, '_');
}
window.plantumlRender = async function(container) {
	const blocks = container.querySelectorAll('pre.plantuml');
	if (!blocks.length) return;
	let pako;
	try {
		pako = await loadPako();
	} catch (e) {
		return;
	}
	for (const el of blocks) {
		if (el.dataset.processed) continue;
		el.dataset.processed = 'true';
		try {
			const encoded = krokiEncode(pako, el.textContent.trim());
			const img = document.createElement('img');
			img.src = 'https://kroki.io/plantuml/svg/' + encoded;
			img.alt = 'PlantUML diagram';
			img.loading = 'lazy';
			img.style.maxWidth = '100%';
			img.onerror = () => {
				const err = document.createElement('div');
				err.className = 'alert alert-danger';
				err.textContent = 'PlantUML render failed (Kroki unreachable).';
				img.replaceWith(err);
			};
			el.replaceWith(img);
		} catch (e) {
			const err = document.createElement('div');
			err.className = 'alert alert-danger';
			err.textContent = 'PlantUML error: ' + e.message;
			el.replaceWith(err);
		}
	}
};
// WaveDrom (FencedRenderExtension::wavedrom()): <pre class="wavedrom"> holds the
// timing-diagram JSON. Digital waveforms are outside Mermaid's scope entirely.
let wavedromPromise = null;
window.wavedromRender = async function(container) {
	const blocks = container.querySelectorAll('pre.wavedrom');
	if (!blocks.length) return;
	if (!wavedromPromise) {
		wavedromPromise = import('https://cdn.jsdelivr.net/npm/wavedrom@3.5.0/+esm').catch(() => null);
	}
	const wavedrom = (await wavedromPromise)?.default;
	if (!wavedrom) return;
	blocks.forEach((el, i) => {
		if (el.dataset.processed) return;
		el.dataset.processed = 'true';
		let spec;
		try {
			// WaveDrom specs are JS object literals (unquoted keys); eval in a
			// sandboxed Function is the library's own accepted input form.
			spec = Function('return (' + el.textContent + ')')();
		} catch (e) {
			const err = document.createElement('div');
			err.className = 'alert alert-danger';
			err.textContent = 'WaveDrom JSON error: ' + e.message;
			el.replaceWith(err);
			return;
		}
		try {
			// renderAny returns an onml tree; stringify it to a standalone SVG
			// and inject it (no id-based DOM lookup, so it works out of a live
			// document tree).
			const svg = wavedrom.onml.stringify(wavedrom.renderAny(i, spec, wavedrom.waveSkin));
			const wrap = document.createElement('div');
			wrap.innerHTML = svg;
			el.replaceWith(wrap);
		} catch (e) {
			const err = document.createElement('div');
			err.className = 'alert alert-danger';
			err.textContent = 'WaveDrom error: ' + e.message;
			el.replaceWith(err);
		}
	});
};
// Vega-Lite (FencedRenderExtension text mode): <pre class="vega-lite"> holds the
// spec JSON. Real statistical charts (aggregation, faceting) beyond Mermaid.
let vegaPromise = null;
window.vegaLiteRender = async function(container) {
	const blocks = container.querySelectorAll('pre.vega-lite');
	if (!blocks.length) return;
	if (!vegaPromise) {
		vegaPromise = import('https://cdn.jsdelivr.net/npm/vega-embed@6/+esm').catch(() => null);
	}
	const mod = await vegaPromise;
	const embed = mod?.default;
	if (!embed) return;
	for (const el of blocks) {
		if (el.dataset.processed) continue;
		el.dataset.processed = 'true';
		let spec;
		try {
			spec = JSON.parse(el.textContent);
		} catch (e) {
			const err = document.createElement('div');
			err.className = 'alert alert-danger';
			err.textContent = 'Vega-Lite JSON error: ' + e.message;
			el.replaceWith(err);
			continue;
		}
		const wrap = document.createElement('div');
		el.replaceWith(wrap);
		try {
			await embed(wrap, spec, { actions: false });
		} catch (e) {
			const err = document.createElement('div');
			err.className = 'alert alert-danger';
			err.textContent = 'Vega-Lite error: ' + e.message;
			wrap.replaceWith(err);
		}
	}
};
</script>
<?php
$this->end();
?>
<?= $this->element('carve/output_styles') ?>

<div class="row">
<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Carve Extensions</h2>
<p>
	The Carve-PHP library includes a powerful extension system that allows you to customize document processing.
	These built-in extensions demonstrate the capabilities.
</p>

<div class="alert alert-info">
	<strong>How Extensions Work:</strong>
	Extensions can register inline patterns (for custom syntax like @mentions),
	block patterns (for custom block elements), and render event listeners (to modify output).
</div>

<div class="card mb-4">
	<div class="card-header">
		<h5 class="mb-0">Table of Contents</h5>
	</div>
	<div class="card-body">
		<div class="toc-columns">
			<?php foreach ($groupedExamples as $category => $items) { ?>
			<div class="toc-group">
				<div class="fw-semibold mb-1"><?= h($category) ?></div>
				<ul class="list-unstyled mb-0">
					<?php foreach ($items as $key => $example) { ?>
					<li><a href="#ext-<?= h($key) ?>"><code><?= h($example['name']) ?></code></a></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
			<div class="toc-group">
				<div class="fw-semibold mb-1">Demos</div>
				<ul class="list-unstyled mb-0">
					<li><a href="#ext-toc-position">TOC Auto-Insert Position Demo</a></li>
					<li><a href="#ext-combined">Combined Extensions Demo</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php foreach ($groupedExamples as $category => $items) { ?>
<h3 class="mt-5 mb-3 pb-1 border-bottom"><?= h($category) ?></h3>
<?php foreach ($items as $key => $example) { ?>
<div class="card mb-4" id="ext-<?= h($key) ?>">
	<div class="card-header">
		<h4 class="mb-0">
			<code><?= h($example['name']) ?></code>
			<a class="header-anchor" href="#ext-<?= h($key) ?>" title="Link to this extension" aria-label="Link to this extension">#</a>
		</h4>
	</div>
	<div class="card-body">
		<p class="lead"><?= preg_replace('/`([^`]+)`/', '<code>$1</code>', h($example['description'])) ?></p>

		<div class="row mb-3">
			<div class="col-md-4">
				<h6>Constructor Options:</h6>
				<?php $options = $example['options'] ?? []; ?>
				<?php if ($options) { ?>
					<table class="table table-sm table-bordered">
						<tbody>
						<?php foreach ($options as $option => $value) { ?>
							<tr>
								<td><code><?= h($option) ?></code></td>
								<td><code><?= h($value) ?></code></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				<?php } else { ?>
					<p class="text-muted small mb-0">None - no constructor arguments.</p>
				<?php } ?>
			</div>
			<div class="col-md-8">
				<h6>Usage Example:</h6>
				<?php if ($key === 'frontmatter') { ?>
				<pre class="bg-light p-2 border rounded"><code class="language-php">$ext = new <?= h($example['name']) ?>();
$converter = new CarveConverter();
$converter->addExtension($ext);

$html = $converter->convert($carve);

// Retrieve the frontmatter after conversion
$fm = $ext->getFrontmatter();
if ($fm !== null) {
    $format = $fm->getFormat();  // 'yaml', 'toml', 'neon'
    $content = $fm->getContent(); // Raw string content
}</code></pre>
				<?php } else { ?>
				<pre class="bg-light p-2 border rounded"><code class="language-php">$converter = new CarveConverter();
$converter->addExtension(new <?= h($example['name']) ?>());

$html = $converter->convert($carve);</code></pre>
				<?php } ?>
			</div>
		</div>

		<h6>Live Demo:</h6>
		<div class="row">
			<div class="col-md-6">
				<div class="mb-2">
					<label class="form-label">Carve Input:</label>
					<textarea class="form-control font-monospace carve-input" rows="8" data-extension="<?= h($key) ?>"><?= h($example['example_carve']) ?></textarea>
				</div>
				<button class="btn btn-primary btn-sm convert-btn" data-extension="<?= h($key) ?>">
					<i class="bi bi-arrow-right-circle"></i> Convert
				</button>
			</div>
			<div class="col-md-6">
				<label class="form-label">HTML Output:</label>
				<div class="border rounded p-3 bg-white html-output carve carve-rendered" data-extension="<?= h($key) ?>" style="min-height: 150px;">
					<span class="text-muted">Click "Convert" to see the output...</span>
				</div>
				<?php if ($key === 'toc') { ?>
				<label class="form-label mt-2">Table of Contents (manual retrieval):</label>
				<div class="border rounded p-3 bg-light toc-output carve" data-extension="<?= h($key) ?>" style="min-height: 100px;">
					<span class="text-muted">TOC will appear here...</span>
				</div>
				<?php } ?>
				<?php if ($key === 'smart_quotes') { ?>
				<div class="mt-2 mb-2">
					<label class="form-label" for="smart-quotes-locale"><code>locale</code>:</label>
					<select class="form-select form-select-sm smart-quotes-locale" id="smart-quotes-locale" data-extension="<?= h($key) ?>" style="width: auto; display: inline-block;">
						<option value="en">en - English "..."  '...'</option>
						<option value="de" selected>de - German „..."  ‚...'</option>
						<option value="de-CH">de-CH - Swiss «...»  ‹...›</option>
						<option value="fr">fr - French « ... »  ‹ ... ›</option>
						<option value="it">it - Italian «...»  "..."</option>
						<option value="es">es - Spanish «...»  "..."</option>
						<option value="pt">pt - Portuguese «...»  "..."</option>
						<option value="nl">nl - Dutch "..."  '...'</option>
						<option value="pl">pl - Polish „..."  ‚...'</option>
						<option value="cs">cs - Czech „..."  ‚...'</option>
						<option value="hu">hu - Hungarian „..."  ‚...'</option>
						<option value="da">da - Danish „..."  ‚...'</option>
						<option value="sv">sv - Swedish "..."  '...'</option>
						<option value="fi">fi - Finnish "..."  '...'</option>
						<option value="nb">nb - Norwegian «...»  '...'</option>
						<option value="ru">ru - Russian «...»  „..."</option>
						<option value="uk">uk - Ukrainian «...»  „..."</option>
						<option value="ja">ja - Japanese 「...」  『...』</option>
						<option value="zh">zh - Chinese 「...」  『...』</option>
					</select>
				</div>
				<?php } ?>
				<?php if ($key === 'frontmatter') { ?>
				<?php if ($this->Configure->read('debug')) { ?>
				<div class="form-check mt-2 mb-2">
					<input class="form-check-input frontmatter-comment-toggle" type="checkbox" id="frontmatter-render-comment" data-extension="<?= h($key) ?>">
					<label class="form-check-label" for="frontmatter-render-comment">
						<code>renderAsComment: true</code> <small class="text-muted">(output frontmatter as HTML comment)</small>
					</label>
				</div>
				<?php } ?>
				<label class="form-label">Parsed Frontmatter (via <code>getFrontmatter()</code>):</label>
				<div class="border rounded p-3 bg-light frontmatter-output" data-extension="<?= h($key) ?>" style="min-height: 100px;">
					<span class="text-muted">Frontmatter data will appear here...</span>
				</div>
				<?php } ?>
			</div>
		</div>

		<div class="mt-3">
			<h6>View Raw HTML:</h6>
			<pre class="bg-dark text-light p-2 border rounded raw-html-output" data-extension="<?= h($key) ?>" style="max-height: 150px; overflow-y: auto; font-size: 0.8em;"><code>Click "Convert" to see raw HTML...</code></pre>
		</div>
	</div>
</div>
<?php } ?>
<?php } ?>

<div class="card mb-4" id="ext-toc-position">
	<div class="card-header bg-info text-white">
		<h4 class="mb-0">
			<i class="bi bi-list-nested"></i> TOC Auto-Insert Position Demo
		</h4>
	</div>
	<div class="card-body">
		<p class="lead">
			The TableOfContentsExtension can automatically insert the TOC at the top or bottom of your content
			using the <code>position</code> parameter.
		</p>

		<div class="row mb-3">
			<div class="col-md-6">
				<h6>Usage Example:</h6>
				<pre class="bg-light p-2 border rounded"><code class="language-php">// Auto-insert TOC at top of content
$converter->addExtension(new TableOfContentsExtension(
    position: 'top',
));

// Or at bottom
$converter->addExtension(new TableOfContentsExtension(
    position: 'bottom',
));</code></pre>
			</div>
			<div class="col-md-6">
				<h6>Position Options:</h6>
				<div class="btn-group w-100 mb-3" role="group">
					<input type="radio" class="btn-check" name="toc-position" id="toc-pos-top" value="top" checked>
					<label class="btn btn-outline-info" for="toc-pos-top">Top</label>
					<input type="radio" class="btn-check" name="toc-position" id="toc-pos-bottom" value="bottom">
					<label class="btn btn-outline-info" for="toc-pos-bottom">Bottom</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-5">
				<div class="mb-2">
					<label class="form-label">Carve Input:</label>
					<textarea class="form-control font-monospace" id="toc-position-input" rows="10"># Welcome

Introduction paragraph.

## Getting Started

First steps to begin.

### Installation

How to install.

## Configuration

Setup options.

## Conclusion

Final thoughts.</textarea>
				</div>
				<button class="btn btn-info" id="toc-position-convert-btn">
					<i class="bi bi-arrow-right-circle"></i> Convert with Position
				</button>
			</div>
			<div class="col-md-7">
				<label class="form-label">HTML Output (with TOC auto-inserted):</label>
				<div class="border rounded p-3 bg-white carve" id="toc-position-output" style="min-height: 200px; max-height: 400px; overflow-y: auto;">
					<span class="text-muted">Click "Convert" to see the output with TOC inserted...</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card mb-4" id="ext-combined">
	<div class="card-header bg-success text-white">
		<h4 class="mb-0">
			<i class="bi bi-layers"></i> Combined Extensions Demo
		</h4>
	</div>
	<div class="card-body">
		<p class="lead">Extensions can be combined! Enable multiple extensions to see how they work together.</p>

		<div class="row mb-3">
			<div class="col-12">
				<h6>Enable Extensions:</h6>
				<div class="d-flex flex-wrap gap-3">
					<?php foreach ($examples as $key => $example) { ?>
					<div class="form-check">
						<input class="form-check-input combined-ext-toggle" type="checkbox" value="<?= h($key) ?>" id="toggle-<?= h($key) ?>" checked>
						<label class="form-check-label" for="toggle-<?= h($key) ?>">
							<?= h($example['name']) ?>
						</label>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="mb-2">
					<label class="form-label">Carve Input:</label>
					<textarea class="form-control font-monospace" id="combined-input" rows="12"># Welcome to Carve Extensions

Check out https://github.com/markup-carve/carve for the official documentation.

## Features

Thanks to @johndoe for implementing this!

Visit [GitHub](https://github.com/markup-carve/carve-php) for the source code.

### Contact

Reach out at support@example.com for help.

Or contact @alice and @bob directly.</textarea>
				</div>
				<button class="btn btn-success" id="combined-convert-btn">
					<i class="bi bi-play-fill"></i> Convert with Selected Extensions
				</button>
			</div>
			<div class="col-md-6">
				<label class="form-label">HTML Output:</label>
				<div class="border rounded p-3 bg-white carve carve-rendered" id="combined-html-output" style="min-height: 200px;">
					<span class="text-muted">Click "Convert" to see the output...</span>
				</div>
				<label class="form-label mt-2">Table of Contents:</label>
				<div class="border rounded p-3 bg-light carve" id="combined-toc-output" style="min-height: 80px;">
					<span class="text-muted">TOC will appear here (if enabled)...</span>
				</div>
			</div>
		</div>

		<div class="mt-3">
			<h6>View Raw HTML:</h6>
			<pre class="bg-dark text-light p-2 border rounded" id="combined-raw-output" style="max-height: 200px; overflow-y: auto; font-size: 0.8em;"><code>Click "Convert" to see raw HTML...</code></pre>
		</div>
	</div>
</div>

</div>
</div>

<style>
/* Per-extension header anchor: faded until the card header is hovered */
.card-header h4 .header-anchor {
	margin-left: 0.4rem;
	color: #adb5bd;
	font-weight: 400;
	text-decoration: none;
	opacity: 0;
	transition: opacity 0.12s;
}
.card-header:hover .header-anchor,
.header-anchor:focus {
	opacity: 1;
}
.header-anchor:hover {
	color: #0d6efd;
}
/* Table of Contents: balanced multi-column, groups kept intact */
.toc-columns {
	column-count: 3;
	column-gap: 1.5rem;
}
.toc-group {
	break-inside: avoid;
	margin-bottom: 0.85rem;
}
@media (max-width: 992px) {
	.toc-columns { column-count: 2; }
}
@media (max-width: 576px) {
	.toc-columns { column-count: 1; }
}

#toc-position-output nav.toc {
	background-color: #f8f9fa;
	border: 1px solid #dee2e6;
	border-radius: 0.375rem;
	padding: 1rem;
	margin-bottom: 1rem;
	font-size: 0.9em;
}
#toc-position-output nav.toc::before {
	content: "Table of Contents";
	display: block;
	font-weight: bold;
	margin-bottom: 0.5rem;
	color: #495057;
}
#toc-position-output nav.toc ul {
	list-style: none;
	padding-left: 1em;
	margin: 0;
}
#toc-position-output nav.toc > ul {
	padding-left: 0;
}
#toc-position-output nav.toc li {
	margin: 0.25em 0;
}
#toc-position-output nav.toc a {
	text-decoration: none;
	color: #0d6efd;
}
#toc-position-output nav.toc a:hover {
	text-decoration: underline;
}
</style>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const convertUrl = <?= json_encode($this->Url->build(['action' => 'convertWithExtensions'])) ?>;

	// Individual extension demos
	document.querySelectorAll('.convert-btn').forEach(btn => {
		btn.addEventListener('click', async function() {
			const ext = this.dataset.extension;
			const input = document.querySelector(`.carve-input[data-extension="${ext}"]`);
			const htmlOutput = document.querySelector(`.html-output[data-extension="${ext}"]`);
			const rawOutput = document.querySelector(`.raw-html-output[data-extension="${ext}"]`);
			const tocOutput = document.querySelector(`.toc-output[data-extension="${ext}"]`);
			const frontmatterOutput = document.querySelector(`.frontmatter-output[data-extension="${ext}"]`);
			const frontmatterCommentToggle = document.querySelector(`.frontmatter-comment-toggle[data-extension="${ext}"]`);
			const smartQuotesLocale = document.querySelector(`.smart-quotes-locale[data-extension="${ext}"]`);

			this.disabled = true;
			this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Converting...';

			try {
				const params = new URLSearchParams({
					carve: input.value,
					'extensions[]': ext,
				});
				if (frontmatterCommentToggle && frontmatterCommentToggle.checked) {
					params.append('frontmatter_as_comment', '1');
				}
				if (smartQuotesLocale) {
					params.append('smart_quotes_locale', smartQuotesLocale.value);
				}

				const response = await fetch(convertUrl, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
						'X-Requested-With': 'XMLHttpRequest',
					},
					body: params,
				});

				const result = await response.json();

				if (result.error) {
					htmlOutput.innerHTML = '<div class="alert alert-danger">' + escapeHtml(result.error) + '</div>';
					rawOutput.querySelector('code').textContent = 'Error: ' + result.error;
				} else {
					htmlOutput.innerHTML = result.html || '<span class="text-muted">No output</span>';
					rawOutput.querySelector('code').textContent = result.rawHtml || result.html || 'No output';

					if (tocOutput && result.toc) {
						tocOutput.innerHTML = result.toc;
					}

					// Display frontmatter data if present
					if (frontmatterOutput && result.frontmatter) {
						frontmatterOutput.innerHTML =
							'<div class="mb-2"><strong>Format:</strong> <code>' + escapeHtml(result.frontmatter.format) + '</code></div>' +
							'<div><strong>Content:</strong></div>' +
							'<pre class="bg-dark text-light p-2 rounded mt-1 mb-0" style="font-size: 0.85em;"><code>' + escapeHtml(result.frontmatter.content) + '</code></pre>';
					} else if (frontmatterOutput) {
						frontmatterOutput.innerHTML = '<span class="text-muted">No frontmatter found in document</span>';
					}

					// Render Mermaid diagrams if present
					if (window.mermaidRender) {
						await window.mermaidRender(htmlOutput);
					}
					if (window.plantumlRender) {
						await window.plantumlRender(htmlOutput);
					}
					if (window.wavedromRender) {
						await window.wavedromRender(htmlOutput);
					}
					if (window.vegaLiteRender) {
						await window.vegaLiteRender(htmlOutput);
					}
					if (window.mathRender) {
						window.mathRender(htmlOutput);
					}
					if (window.chartRender) {
						window.chartRender(htmlOutput);
					}
					if (window.spoilerWire) {
						window.spoilerWire(htmlOutput);
					}
				}
			} catch (e) {
				htmlOutput.innerHTML = '<div class="alert alert-danger">Request failed: ' + escapeHtml(e.message) + '</div>';
			}

			this.disabled = false;
			this.innerHTML = '<i class="bi bi-arrow-right-circle"></i> Convert';
		});
	});

	// TOC position demo
	document.getElementById('toc-position-convert-btn').addEventListener('click', async function() {
		const input = document.getElementById('toc-position-input');
		const output = document.getElementById('toc-position-output');
		const position = document.querySelector('input[name="toc-position"]:checked').value;

		this.disabled = true;
		this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Converting...';

		try {
			const response = await fetch(convertUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'X-Requested-With': 'XMLHttpRequest',
				},
				body: new URLSearchParams({
					carve: input.value,
					'extensions[]': position === 'top' ? 'toc_top' : 'toc_bottom',
				}),
			});

			const result = await response.json();

			if (result.error) {
				output.innerHTML = '<div class="alert alert-danger">' + escapeHtml(result.error) + '</div>';
			} else {
				output.innerHTML = result.html || '<span class="text-muted">No output</span>';
			}
		} catch (e) {
			output.innerHTML = '<div class="alert alert-danger">Request failed: ' + escapeHtml(e.message) + '</div>';
		}

		this.disabled = false;
		this.innerHTML = '<i class="bi bi-arrow-right-circle"></i> Convert with Position';
	});

	// Combined demo
	document.getElementById('combined-convert-btn').addEventListener('click', async function() {
		const input = document.getElementById('combined-input');
		const htmlOutput = document.getElementById('combined-html-output');
		const rawOutput = document.getElementById('combined-raw-output');
		const tocOutput = document.getElementById('combined-toc-output');

		const enabledExtensions = Array.from(document.querySelectorAll('.combined-ext-toggle:checked'))
			.map(cb => cb.value);

		this.disabled = true;
		this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Converting...';

		try {
			const params = new URLSearchParams();
			params.append('carve', input.value);
			enabledExtensions.forEach(ext => params.append('extensions[]', ext));

			const response = await fetch(convertUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'X-Requested-With': 'XMLHttpRequest',
				},
				body: params,
			});

			const result = await response.json();

			if (result.error) {
				htmlOutput.innerHTML = '<div class="alert alert-danger">' + escapeHtml(result.error) + '</div>';
				rawOutput.querySelector('code').textContent = 'Error: ' + result.error;
			} else {
				htmlOutput.innerHTML = result.html || '<span class="text-muted">No output</span>';
				rawOutput.querySelector('code').textContent = result.html || 'No output';

				if (result.toc) {
					tocOutput.innerHTML = result.toc;
				} else {
					tocOutput.innerHTML = '<span class="text-muted">TOC extension not enabled or no headings found</span>';
				}

				// Render Mermaid diagrams if present
				if (window.mermaidRender) {
					await window.mermaidRender(htmlOutput);
				}
				if (window.mathRender) {
					window.mathRender(htmlOutput);
				}
				if (window.chartRender) {
					window.chartRender(htmlOutput);
				}
				if (window.spoilerWire) {
					window.spoilerWire(htmlOutput);
				}
			}
		} catch (e) {
			htmlOutput.innerHTML = '<div class="alert alert-danger">Request failed: ' + escapeHtml(e.message) + '</div>';
		}

		this.disabled = false;
		this.innerHTML = '<i class="bi bi-play-fill"></i> Convert with Selected Extensions';
	});

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	// Highlight PHP code blocks
	document.querySelectorAll('pre code.language-php').forEach(el => {
		hljs.highlightElement(el);
	});
})();
<?php $this->Html->scriptEnd(); ?>
