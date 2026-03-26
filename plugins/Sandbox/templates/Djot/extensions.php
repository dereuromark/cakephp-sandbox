<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array<string, mixed>> $examples
 */

$this->append('script');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-djot.js');
?>
<script type="module">
import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.esm.min.mjs';
mermaid.initialize({ startOnLoad: false, theme: 'default' });
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
			el.innerHTML = '<div class="alert alert-danger">Mermaid error: ' + e.message + '</div>';
		}
	}
};
</script>
<?php
$this->end();
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Djot Extensions</h2>
<p>
	The Djot-PHP library includes a powerful extension system that allows you to customize document processing.
	These built-in extensions demonstrate the capabilities.
</p>

<div class="alert alert-info">
	<strong>How Extensions Work:</strong>
	Extensions can register inline patterns (for custom syntax like @mentions),
	block patterns (for custom block elements), and render event listeners (to modify output).
</p>
</div>

<div class="card mb-4">
	<div class="card-header">
		<h5 class="mb-0">Table of Contents</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<ul class="list-unstyled mb-0">
					<?php foreach ($examples as $key => $example) { ?>
					<li><a href="#ext-<?= h($key) ?>"><code><?= h($example['name']) ?></code></a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-md-6">
				<ul class="list-unstyled mb-0">
					<li><a href="#ext-toc-position">TOC Auto-Insert Position Demo</a></li>
					<li><a href="#ext-combined">Combined Extensions Demo</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php foreach ($examples as $key => $example) { ?>
<div class="card mb-4" id="ext-<?= h($key) ?>">
	<div class="card-header">
		<h4 class="mb-0">
			<code><?= h($example['name']) ?></code>
		</h4>
	</div>
	<div class="card-body">
		<p class="lead"><?= h($example['description']) ?></p>

		<div class="row mb-3">
			<div class="col-md-4">
				<h6>Constructor Options:</h6>
				<table class="table table-sm table-bordered">
					<tbody>
					<?php foreach ($example['options'] as $option => $value) { ?>
						<tr>
							<td><code><?= h($option) ?></code></td>
							<td><code><?= h($value) ?></code></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="col-md-8">
				<h6>Usage Example:</h6>
				<?php if ($key === 'frontmatter') { ?>
				<pre class="bg-light p-2 border rounded"><code class="language-php">$ext = new <?= h($example['name']) ?>();
$converter = new DjotConverter();
$converter->addExtension($ext);

$html = $converter->convert($djot);

// Retrieve the frontmatter after conversion
$fm = $ext->getFrontmatter();
if ($fm !== null) {
    $format = $fm->getFormat();  // 'yaml', 'toml', 'neon'
    $content = $fm->getContent(); // Raw string content
}</code></pre>
				<?php } else { ?>
				<pre class="bg-light p-2 border rounded"><code class="language-php">$converter = new DjotConverter();
$converter->addExtension(new <?= h($example['name']) ?>());

$html = $converter->convert($djot);</code></pre>
				<?php } ?>
			</div>
		</div>

		<h6>Live Demo:</h6>
		<div class="row">
			<div class="col-md-6">
				<div class="mb-2">
					<label class="form-label">Djot Input:</label>
					<textarea class="form-control font-monospace djot-input" rows="8" data-extension="<?= h($key) ?>"><?= h($example['example_djot']) ?></textarea>
				</div>
				<button class="btn btn-primary btn-sm convert-btn" data-extension="<?= h($key) ?>">
					<i class="bi bi-arrow-right-circle"></i> Convert
				</button>
			</div>
			<div class="col-md-6">
				<label class="form-label">HTML Output:</label>
				<div class="border rounded p-3 bg-white html-output" data-extension="<?= h($key) ?>" style="min-height: 150px;">
					<span class="text-muted">Click "Convert" to see the output...</span>
				</div>
				<?php if ($key === 'toc') { ?>
				<label class="form-label mt-2">Table of Contents (manual retrieval):</label>
				<div class="border rounded p-3 bg-light toc-output" data-extension="<?= h($key) ?>" style="min-height: 100px;">
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
					<label class="form-label">Djot Input:</label>
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
				<div class="border rounded p-3 bg-white" id="toc-position-output" style="min-height: 200px; max-height: 400px; overflow-y: auto;">
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
					<label class="form-label">Djot Input:</label>
					<textarea class="form-control font-monospace" id="combined-input" rows="12"># Welcome to Djot Extensions

Check out https://djot.net for the official documentation.

## Features

Thanks to @johndoe for implementing this!

Visit [GitHub](https://github.com/php-collective/djot-php) for the source code.

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
				<div class="border rounded p-3 bg-white" id="combined-html-output" style="min-height: 200px;">
					<span class="text-muted">Click "Convert" to see the output...</span>
				</div>
				<label class="form-label mt-2">Table of Contents:</label>
				<div class="border rounded p-3 bg-light" id="combined-toc-output" style="min-height: 80px;">
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

<style>
.html-output a[target="_blank"]::after {
	content: " \f1c5";
	font-family: "bootstrap-icons";
	font-size: 0.75em;
	vertical-align: super;
}
.html-output .mention {
	background-color: #e7f3ff;
	padding: 0.1em 0.3em;
	border-radius: 3px;
	color: #0969da;
}
.html-output .permalink {
	text-decoration: none;
	opacity: 0.3;
	margin-left: 0.3em;
}
.html-output .permalink:hover {
	opacity: 1;
}
.html-output section {
	margin-bottom: 1em;
}
.html-output kbd {
	background-color: #f8f9fa;
	border: 1px solid #dee2e6;
	border-radius: 3px;
	padding: 0.1em 0.4em;
	font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
	font-size: 0.9em;
	box-shadow: inset 0 -1px 0 rgba(0,0,0,0.1);
	color: #212529;
}
.html-output dfn {
	font-style: italic;
	font-weight: 500;
	color: #0d6efd;
}
.html-output abbr[title] {
	text-decoration: underline dotted;
	cursor: help;
}
.toc-output nav.toc {
	font-size: 0.9em;
}
.toc-output nav.toc ul {
	list-style: none;
	padding-left: 1em;
	margin: 0;
}
.toc-output nav.toc > ul {
	padding-left: 0;
}
.toc-output nav.toc li {
	margin: 0.25em 0;
}
.toc-output nav.toc a {
	text-decoration: none;
}
.toc-output nav.toc a:hover {
	text-decoration: underline;
}
#combined-html-output .mention,
#combined-toc-output nav.toc ul,
#combined-toc-output nav.toc > ul,
#combined-toc-output nav.toc li,
#combined-toc-output nav.toc a {
	/* Inherit styles from above */
}
#combined-html-output .mention {
	background-color: #e7f3ff;
	padding: 0.1em 0.3em;
	border-radius: 3px;
	color: #0969da;
}
#combined-html-output .permalink {
	text-decoration: none;
	opacity: 0.3;
	margin-left: 0.3em;
}
#combined-html-output .permalink:hover {
	opacity: 1;
}
#combined-html-output kbd {
	background-color: #f8f9fa;
	border: 1px solid #dee2e6;
	border-radius: 3px;
	padding: 0.1em 0.4em;
	font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
	font-size: 0.9em;
	box-shadow: inset 0 -1px 0 rgba(0,0,0,0.1);
	color: #212529;
}
#combined-html-output dfn {
	font-style: italic;
	font-weight: 500;
	color: #0d6efd;
}
#combined-html-output abbr[title] {
	text-decoration: underline dotted;
	cursor: help;
}
#combined-toc-output nav.toc {
	font-size: 0.9em;
}
#combined-toc-output nav.toc ul {
	list-style: none;
	padding-left: 1em;
	margin: 0;
}
#combined-toc-output nav.toc > ul {
	padding-left: 0;
}
#combined-toc-output nav.toc li {
	margin: 0.25em 0;
}
#combined-toc-output nav.toc a {
	text-decoration: none;
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
/* Admonition styles */
.html-output .admonition {
	border-left: 4px solid;
	padding: 1rem;
	margin: 1rem 0;
	border-radius: 0.375rem;
	background-color: #f8f9fa;
}
.html-output .admonition-title {
	font-weight: bold;
	margin: 0 0 0.5rem 0;
	display: flex;
	align-items: center;
	gap: 0.5rem;
}
.html-output .admonition-icon {
	font-size: 1.1em;
	flex-shrink: 0;
}
.html-output .admonition.note {
	border-color: #0d6efd;
	background-color: #cfe2ff;
}
.html-output .admonition.tip {
	border-color: #198754;
	background-color: #d1e7dd;
}
.html-output .admonition.warning {
	border-color: #ffc107;
	background-color: #fff3cd;
}
.html-output .admonition.danger {
	border-color: #dc3545;
	background-color: #f8d7da;
}
.html-output .admonition.info {
	border-color: #0dcaf0;
	background-color: #cff4fc;
}
.html-output .admonition.success {
	border-color: #198754;
	background-color: #d1e7dd;
}
/* Collapsible admonitions */
.html-output details.admonition {
	border-left: 4px solid;
	padding: 1rem;
	margin: 1rem 0;
	border-radius: 0.375rem;
}
.html-output details.admonition summary {
	cursor: pointer;
	font-weight: bold;
	margin-bottom: 0.5rem;
	display: flex;
	align-items: center;
	gap: 0.5rem;
}
.html-output details.admonition summary .admonition-icon {
	font-size: 1.1em;
}
.html-output details.admonition[open] summary {
	margin-bottom: 0.5rem;
}
/* Tabs styles (CSS-only mode) */
.html-output .tabs {
	display: flex;
	flex-wrap: wrap;
	border: 1px solid #dee2e6;
	border-radius: 0.375rem;
	overflow: hidden;
}
.html-output .tabs-radio {
	display: none;
}
.html-output .tabs-label {
	padding: 0.5rem 1rem;
	cursor: pointer;
	background-color: #f8f9fa;
	border-bottom: 2px solid transparent;
	transition: all 0.2s;
}
.html-output .tabs-label:hover {
	background-color: #e9ecef;
}
.html-output .tabs-radio:checked + .tabs-label {
	background-color: #fff;
	border-bottom-color: #0d6efd;
	font-weight: 500;
}
.html-output .tabs-panel {
	display: none;
	width: 100%;
	order: 1;
	padding: 1rem;
	background-color: #fff;
}
.html-output .tabs-radio:nth-of-type(1):checked ~ .tabs-panel:nth-of-type(1),
.html-output .tabs-radio:nth-of-type(2):checked ~ .tabs-panel:nth-of-type(2),
.html-output .tabs-radio:nth-of-type(3):checked ~ .tabs-panel:nth-of-type(3),
.html-output .tabs-radio:nth-of-type(4):checked ~ .tabs-panel:nth-of-type(4),
.html-output .tabs-radio:nth-of-type(5):checked ~ .tabs-panel:nth-of-type(5) {
	display: block;
}
/* Tabs ARIA mode button styles */
.html-output .tabs button.tabs-label {
	border: none;
	font-size: inherit;
	font-family: inherit;
}
.html-output .tabs button.tabs-label[aria-selected="true"] {
	background-color: #fff;
	border-bottom: 2px solid #0d6efd;
	font-weight: 500;
}
.html-output .tabs [role="tabpanel"] {
	padding: 1rem;
	width: 100%;
	order: 1;
	background-color: #fff;
}
.html-output .tabs [role="tabpanel"][hidden] {
	display: none;
}
/* Mermaid diagram styles */
.html-output .mermaid {
	background-color: #fff;
	padding: 1rem;
	border-radius: 0.375rem;
	text-align: center;
}
.html-output .mermaid-figure {
	margin: 1rem 0;
	text-align: center;
}
/* Wikilinks styles */
.html-output .wikilink {
	color: #0969da;
	text-decoration: none;
	border-bottom: 1px dashed #0969da;
}
.html-output .wikilink:hover {
	border-bottom-style: solid;
}
</style>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const convertUrl = <?= json_encode($this->Url->build(['action' => 'convertWithExtensions'])) ?>;

	// Individual extension demos
	document.querySelectorAll('.convert-btn').forEach(btn => {
		btn.addEventListener('click', async function() {
			const ext = this.dataset.extension;
			const input = document.querySelector(`.djot-input[data-extension="${ext}"]`);
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
					djot: input.value,
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
					djot: input.value,
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
			params.append('djot', input.value);
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
