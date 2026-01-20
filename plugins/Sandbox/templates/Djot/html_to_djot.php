<?php
/**
 * @var \App\View\AppView $this
 */

$defaultHtml = <<<'HTML'
<h1>HTML to Djot</h1>

<p>This is an <strong>HTML</strong> document.<br>
Try editing this text!</p>

<hr>

<h2>Features</h2>

<ul>
    <li><em>emphasis</em> and <strong>strong</strong> text</li>
    <li><del>deleted</del> and <ins>inserted</ins> text</li>
    <li><mark>highlighted</mark> text</li>
    <li>Links: <a href="https://djot.net">Djot docs</a></li>
    <li>Inline <code>code</code> spans</li>
</ul>

<h3>Code Block</h3>

<pre><code class="language-php">&lt;?php
echo "Hello, World!";</code></pre>

<h3>Blockquote</h3>

<blockquote>
    <p>The best way to predict the future is to invent it.</p>
    <p><em>Alan Kay</em></p>
</blockquote>

<h3>Table</h3>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HTML</td>
            <td>Markup</td>
        </tr>
        <tr>
            <td>PHP</td>
            <td>Code</td>
        </tr>
    </tbody>
</table>

<h3>Definition List</h3>

<dl>
    <dt>Djot</dt>
    <dd>A lightweight markup language with clean syntax.</dd>
    <dt>Markdown</dt>
    <dt>CommonMark</dt>
    <dd>The predecessors that inspired Djot.</dd>
</dl>
HTML;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>HTML to Djot Converter</h2>
<p>
	Convert <a href="https://html.spec.whatwg.org/" target="_blank">HTML</a> content to
	<a href="https://djot.net" target="_blank">Djot</a> markup.
	Edit on the left, see the Djot result on the right.
</p>
<p class="text-muted small">
	Useful for importing HTML content from CMS systems, WYSIWYG editors, or web scraping into Djot format.
	For more conversion options, see <a href="https://pandoc.org/" target="_blank">Pandoc</a>.
</p>

<div id="alert-container"></div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label"><strong>HTML Input</strong></label>
		<textarea id="html-input" class="form-control font-monospace" rows="20" placeholder="Enter HTML..."><?= h($defaultHtml) ?></textarea>
	</div>
	<div class="col-md-6">
		<div class="d-flex justify-content-between align-items-center mb-1">
			<label class="form-label mb-0"><strong>Djot Output</strong></label>
			<div>
				<span id="loading-indicator" class="me-2" style="opacity: 0;">
					<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
				</span>
				<button type="button" class="btn btn-sm btn-outline-secondary" id="btn-copy" title="Copy Djot output">
					<i class="bi bi-clipboard"></i> Copy
				</button>
				<button type="button" class="btn btn-sm btn-outline-primary" id="btn-try" title="Try in Djot Playground">
					<i class="bi bi-play-fill"></i> Try in Playground
				</button>
			</div>
		</div>
		<textarea id="djot-output" class="form-control font-monospace" rows="20" readonly placeholder="Djot output will appear here..."></textarea>
	</div>
</div>

<h3 class="mt-4">Supported HTML Elements</h3>
<div class="row">
	<div class="col-md-4">
		<h6>Block Elements</h6>
		<ul class="small">
			<li><code>&lt;h1&gt;</code>-<code>&lt;h6&gt;</code> - Headings</li>
			<li><code>&lt;p&gt;</code> - Paragraphs</li>
			<li><code>&lt;blockquote&gt;</code> - Blockquotes</li>
			<li><code>&lt;pre&gt;&lt;code&gt;</code> - Code blocks</li>
			<li><code>&lt;ul&gt;</code>, <code>&lt;ol&gt;</code> - Lists</li>
			<li><code>&lt;table&gt;</code> - Tables</li>
			<li><code>&lt;dl&gt;</code> - Definition lists</li>
			<li><code>&lt;hr&gt;</code> - Thematic breaks</li>
		</ul>
	</div>
	<div class="col-md-4">
		<h6>Inline Elements</h6>
		<ul class="small">
			<li><code>&lt;strong&gt;</code>, <code>&lt;b&gt;</code> - Strong</li>
			<li><code>&lt;em&gt;</code>, <code>&lt;i&gt;</code> - Emphasis</li>
			<li><code>&lt;del&gt;</code>, <code>&lt;s&gt;</code> - Deleted</li>
			<li><code>&lt;ins&gt;</code>, <code>&lt;u&gt;</code> - Inserted</li>
			<li><code>&lt;mark&gt;</code> - Highlighted</li>
			<li><code>&lt;sup&gt;</code> - Superscript</li>
			<li><code>&lt;sub&gt;</code> - Subscript</li>
			<li><code>&lt;code&gt;</code> - Inline code</li>
		</ul>
	</div>
	<div class="col-md-4">
		<h6>Other Elements</h6>
		<ul class="small">
			<li><code>&lt;a&gt;</code> - Links</li>
			<li><code>&lt;img&gt;</code> - Images</li>
			<li><code>&lt;br&gt;</code> - Line breaks</li>
			<li><code>&lt;figure&gt;</code> - Figures</li>
			<li><code>&lt;span&gt;</code> - With classes/IDs</li>
		</ul>
	</div>
</div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const htmlInput = document.getElementById('html-input');
	const djotOutput = document.getElementById('djot-output');
	const alertContainer = document.getElementById('alert-container');
	const loadingIndicator = document.getElementById('loading-indicator');
	const btnCopy = document.getElementById('btn-copy');
	const btnTry = document.getElementById('btn-try');

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
		formData.append('html', htmlInput.value);

		fetch('<?= $this->Url->build(['action' => 'convertHtml']) ?>', {
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

	function compress(str) {
		return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, (match, p1) => String.fromCharCode('0x' + p1)));
	}

	htmlInput.addEventListener('input', convert);

	btnTry.addEventListener('click', function() {
		const djot = djotOutput.value;
		if (djot) {
			window.location.href = '<?= $this->Url->build(['action' => 'index']) ?>?d=' + encodeURIComponent(compress(djot));
		}
	});

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
