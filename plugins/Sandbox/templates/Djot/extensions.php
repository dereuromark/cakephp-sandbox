<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array<string, mixed>> $examples
 */

$this->append('script');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-djot.js');
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
				<pre class="bg-light p-2 border rounded"><code class="language-php">$converter = new DjotConverter();
$converter->addExtension(new <?= h($example['name']) ?>());

$html = $converter->convert($djot);</code></pre>
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
						'extensions[]': ext,
					}),
				});

				const result = await response.json();

				if (result.error) {
					htmlOutput.innerHTML = '<div class="alert alert-danger">' + escapeHtml(result.error) + '</div>';
					rawOutput.querySelector('code').textContent = 'Error: ' + result.error;
				} else {
					htmlOutput.innerHTML = result.html || '<span class="text-muted">No output</span>';
					rawOutput.querySelector('code').textContent = result.html || 'No output';

					if (tocOutput && result.toc) {
						tocOutput.innerHTML = result.toc;
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
