<?php
/**
 * @var \App\View\AppView $this
 */

$defaultBbcode = <<<'BBCODE'
[b]Welcome to BBCode![/b]

This is [i]italic[/i] and this is [b]bold[/b] text.
You can also use [u]underline[/u] and [s]strikethrough[/s].

[quote=John]
This is a quoted message from John.
It can span multiple lines.
[/quote]

Here's a list:
[list]
[*]First item
[*]Second item with [b]bold[/b]
[*]Third item
[/list]

And a numbered list:
[list=1]
[*]Step one
[*]Step two
[*]Step three
[/list]

[code=php]
echo "Hello World!";
$x = 42;
[/code]

Check out [url=https://djot.net]the Djot website[/url] for more info.
Or just visit [url]https://example.com[/url].

[img]/img/cake.icon.png[/img]
BBCODE;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>BBCode to Djot Converter</h2>
<p>
	Convert <a href="https://en.wikipedia.org/wiki/BBCode" target="_blank">BBCode</a> syntax to
	<a href="https://djot.net" target="_blank">Djot</a> markup.
	Useful for migrating forum content to Djot format.
</p>

<div id="alert-container"></div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label"><strong>BBCode Input</strong></label>
		<textarea id="bbcode-input" class="form-control font-monospace" rows="20" placeholder="Enter BBCode..."><?= h($defaultBbcode) ?></textarea>
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

<h3 class="mt-4">Conversion Reference</h3>
<p class="text-muted">BBCode tags are converted to their Djot equivalents:</p>
<div class="row">
	<div class="col-md-6">
		<table class="table table-sm">
			<thead>
				<tr>
					<th>Feature</th>
					<th>BBCode</th>
					<th>Djot</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Bold</td>
					<td><code>[b]text[/b]</code></td>
					<td><code>*text*</code></td>
				</tr>
				<tr>
					<td>Italic</td>
					<td><code>[i]text[/i]</code></td>
					<td><code>_text_</code></td>
				</tr>
				<tr>
					<td>Underline</td>
					<td><code>[u]text[/u]</code></td>
					<td><code>{+text+}</code></td>
				</tr>
				<tr>
					<td>Strikethrough</td>
					<td><code>[s]text[/s]</code></td>
					<td><code>{-text-}</code></td>
				</tr>
				<tr>
					<td>Superscript</td>
					<td><code>[sup]text[/sup]</code></td>
					<td><code>^text^</code></td>
				</tr>
				<tr>
					<td>Subscript</td>
					<td><code>[sub]text[/sub]</code></td>
					<td><code>~text~</code></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-sm">
			<thead>
				<tr>
					<th>Feature</th>
					<th>BBCode</th>
					<th>Djot</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Link</td>
					<td><code>[url=...]text[/url]</code></td>
					<td><code>[text](url)</code></td>
				</tr>
				<tr>
					<td>Image</td>
					<td><code>[img]url[/img]</code></td>
					<td><code>![](url)</code></td>
				</tr>
				<tr>
					<td>Code block</td>
					<td><code>[code]...[/code]</code></td>
					<td><code>```...```</code></td>
				</tr>
				<tr>
					<td>Quote</td>
					<td><code>[quote]...[/quote]</code></td>
					<td><code>&gt; ...</code></td>
				</tr>
				<tr>
					<td>List item</td>
					<td><code>[*]item</code></td>
					<td><code>- item</code></td>
				</tr>
				<tr>
					<td>Horizontal rule</td>
					<td><code>[hr]</code></td>
					<td><code>---</code></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<p class="text-muted small mt-3">
	<strong>Note:</strong> Some BBCode features like <code>[size]</code>, <code>[color]</code>, and <code>[font]</code> have no direct Djot equivalent and are stripped during conversion.
</p>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const bbcodeInput = document.getElementById('bbcode-input');
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
		formData.append('bbcode', bbcodeInput.value);

		fetch('<?= $this->Url->build(['action' => 'convertBbcode']) ?>', {
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

	bbcodeInput.addEventListener('input', convert);

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
