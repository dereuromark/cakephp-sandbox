<?php
/**
 * @var \App\View\AppView $this
 */

$defaultMarkdown = <<<'MARKDOWN'
# Markdown to Djot
This is **Markdown** without blank lines.
Notice how Djot adds them automatically!
## Condensed Blocks
> A blockquote right after text
- List without blank line before
- With *emphasis* and **strong**
  - Nested item
### Code Example
```php
echo "Hello!";
```
More text directly after code.
MARKDOWN;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Markdown to Djot Converter</h2>
<p>
	Convert <a href="https://commonmark.org/" target="_blank">Markdown</a> syntax to
	<a href="https://djot.net" target="_blank">Djot</a> markup.
	Edit on the left, see the Djot result on the right.
</p>
<p class="text-muted small">
	For more conversion options (other formats), see <a href="https://pandoc.org/" target="_blank">Pandoc</a> which supports Djot as input/output format.
</p>

<div id="alert-container"></div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label"><strong>Markdown Input</strong></label>
		<textarea id="markdown-input" class="form-control font-monospace" rows="20" placeholder="Enter Markdown..."><?= h($defaultMarkdown) ?></textarea>
	</div>
	<div class="col-md-6">
		<label class="form-label"><strong>Djot Output</strong></label>
		<textarea id="djot-output" class="form-control font-monospace" rows="20" readonly placeholder="Djot output will appear here..."></textarea>
	</div>
</div>

<div class="mt-3">
	<button type="button" class="btn btn-outline-secondary" id="btn-copy" title="Copy Djot output">
		<i class="bi bi-clipboard"></i> Copy
	</button>
	<span id="loading-indicator" class="ms-2" style="opacity: 0;">
		<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
	</span>
</div>

<h3 class="mt-4">Key Differences</h3>
<p class="text-muted">Djot requires some changes from Markdown syntax:</p>
<div class="row">
	<div class="col-md-6">
		<table class="table table-sm">
			<thead>
				<tr>
					<th>Feature</th>
					<th>Markdown</th>
					<th>Djot</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Emphasis</td>
					<td><code>*text*</code></td>
					<td><code>_text_</code></td>
				</tr>
				<tr>
					<td>Strong</td>
					<td><code>**text**</code></td>
					<td><code>*text*</code></td>
				</tr>
				<tr>
					<td>Strikethrough</td>
					<td><code>~~text~~</code></td>
					<td><code>{-text-}</code></td>
				</tr>
				<tr>
					<td>Highlight</td>
					<td><code>==text==</code></td>
					<td><code>{=text=}</code></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-sm">
			<thead>
				<tr>
					<th>Feature</th>
					<th>Markdown</th>
					<th>Djot</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Superscript</td>
					<td><code>&lt;sup&gt;text&lt;/sup&gt;</code></td>
					<td><code>^text^</code></td>
				</tr>
				<tr>
					<td>Subscript</td>
					<td><code>&lt;sub&gt;text&lt;/sub&gt;</code></td>
					<td><code>~text~</code></td>
				</tr>
				<tr>
					<td>Insert</td>
					<td><code>&lt;ins&gt;text&lt;/ins&gt;</code></td>
					<td><code>{+text+}</code></td>
				</tr>
				<tr>
					<td>Block spacing</td>
					<td>Optional</td>
					<td>Required</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const markdownInput = document.getElementById('markdown-input');
	const djotOutput = document.getElementById('djot-output');
	const alertContainer = document.getElementById('alert-container');
	const loadingIndicator = document.getElementById('loading-indicator');
	const btnCopy = document.getElementById('btn-copy');

	let debounceTimer;
	let currentRequest;

	function convert() {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(doConvert, 200);
	}

	function doConvert() {
		if (currentRequest) {
			currentRequest.abort();
		}

		loadingIndicator.style.transition = 'none';
		loadingIndicator.style.opacity = '1';

		const controller = new AbortController();
		currentRequest = controller;

		const formData = new FormData();
		formData.append('markdown', markdownInput.value);

		fetch('<?= $this->Url->build(['action' => 'convertMarkdown']) ?>', {
			method: 'POST',
			body: formData,
			signal: controller.signal,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		.then(response => response.json())
		.then(data => {
			currentRequest = null;
			loadingIndicator.style.transition = 'opacity 0.8s';
			loadingIndicator.style.opacity = '0';
			alertContainer.innerHTML = '';

			if (data.error) {
				alertContainer.innerHTML = '<div class="alert alert-danger py-2"><strong>Error:</strong> ' + escapeHtml(data.error) + '</div>';
			}

			djotOutput.value = data.djot || '';
		})
		.catch(err => {
			loadingIndicator.style.transition = 'opacity 0.8s';
			loadingIndicator.style.opacity = '0';
			if (err.name !== 'AbortError') {
				console.error('Conversion error:', err);
			}
		});
	}

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	function copyToClipboard(text) {
		if (navigator.clipboard && navigator.clipboard.writeText) {
			return navigator.clipboard.writeText(text);
		}
		const textarea = document.createElement('textarea');
		textarea.value = text;
		textarea.style.position = 'fixed';
		textarea.style.opacity = '0';
		document.body.appendChild(textarea);
		textarea.select();
		try {
			document.execCommand('copy');
			document.body.removeChild(textarea);
			return Promise.resolve();
		} catch (e) {
			document.body.removeChild(textarea);
			return Promise.reject(e);
		}
	}

	markdownInput.addEventListener('input', convert);

	btnCopy.addEventListener('click', function() {
		copyToClipboard(djotOutput.value).then(() => {
			const originalHtml = btnCopy.innerHTML;
			btnCopy.innerHTML = '<i class="bi bi-check"></i> Copied!';
			btnCopy.classList.remove('btn-outline-secondary');
			btnCopy.classList.add('btn-success');
			setTimeout(() => {
				btnCopy.innerHTML = originalHtml;
				btnCopy.classList.remove('btn-success');
				btnCopy.classList.add('btn-outline-secondary');
			}, 2000);
		});
	});

	// Initial conversion
	convert();
})();
<?php $this->Html->scriptEnd(); ?>
