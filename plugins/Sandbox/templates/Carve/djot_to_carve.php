<?php
/**
 * @var \App\View\AppView $this
 */

$defaultDjot = <<<'DJOT'
# Djot to Carve

This text uses _Djot emphasis_ and *strong* text.

Subscript like H~2~O, superscript like 2^10^ and a {=highlight=}.

Edits stay braced: {+inserted+} and {-deleted-}.

## Lists and code

- A list item with a [link](https://djot.net)
- Code stays untouched: `_x_`

``` php
echo "Hello!";
```

A footnote reference[^note].

[^note]: The note text.
DJOT;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Djot to Carve Converter</h2>
<p>
	Migrate <a href="https://djot.net" target="_blank">Djot</a> markup to
	<a href="https://github.com/markup-carve/carve" target="_blank">Carve</a> syntax.
	The Djot source is parsed as a document (<code>Carve::importDocument($djot, ['from' => 'djot'])</code>)
	and written back as canonical Carve, so code, link destinations and escapes keep their meaning.
	Edit on the left, see the Carve result on the right.
</p>

<div id="alert-container"></div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label"><strong>Djot Input</strong></label>
		<textarea id="djot-input" class="form-control font-monospace" rows="18" placeholder="Enter Djot..."><?= h($defaultDjot) ?></textarea>
	</div>
	<div class="col-md-6">
		<div class="d-flex justify-content-between align-items-center mb-1">
			<label class="form-label mb-0"><strong>Carve Output</strong></label>
			<div>
				<span id="loading-indicator" class="me-2" style="opacity: 0;">
					<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
				</span>
				<button type="button" class="btn btn-sm btn-outline-secondary" id="btn-copy" title="Copy Carve output">
					<i class="bi bi-clipboard"></i> Copy
				</button>
				<button type="button" class="btn btn-sm btn-outline-primary" id="btn-try" title="Try in Carve Playground">
					<i class="bi bi-play-fill"></i> Try in Playground
				</button>
			</div>
		</div>
		<textarea id="carve-output" class="form-control font-monospace" rows="18" readonly placeholder="Carve output will appear here..."></textarea>
	</div>
</div>

<h3 class="mt-4">Delimiter Changes</h3>
<p class="text-muted">These constructs are spelled differently in Djot and Carve:</p>
<table class="table table-sm w-auto">
	<thead>
		<tr><th>Meaning</th><th>Djot</th><th>Carve</th></tr>
	</thead>
	<tbody>
		<tr><td>Emphasis (italic)</td><td><code>_text_</code></td><td><code>/text/</code></td></tr>
		<tr><td>Subscript</td><td><code>~text~</code></td><td><code>{,text,}</code></td></tr>
		<tr><td>Superscript</td><td><code>^text^</code></td><td><code>{^text^}</code></td></tr>
		<tr><td>Heading</td><td><code>## text</code></td><td><code>== text</code></td></tr>
		<tr><td>Highlight, insert, delete</td><td><code>{=text=}</code>, <code>{+text+}</code>, <code>{-text-}</code></td><td>unchanged</td></tr>
	</tbody>
</table>
<p class="text-muted small">
	Djot <code>**x**</code> is strong inside strong, so it becomes <code>{*{*x*}*}</code>, not Markdown bold.
	The 0.1 delimiter-by-delimiter rewriter is gone: Carve 0.2 imports the parsed document instead.
</p>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const djotInput = document.getElementById('djot-input');
	const carveOutput = document.getElementById('carve-output');
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
		formData.append('djot', djotInput.value);

		fetch('<?= $this->Url->build(['action' => 'convertDjot']) ?>', {
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

			carveOutput.value = data.carve || '';
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

	djotInput.addEventListener('input', convert);

	btnTry.addEventListener('click', function() {
		const carve = carveOutput.value;
		if (carve) {
			window.location.href = '<?= $this->Url->build(['action' => 'index']) ?>?d=' + encodeURIComponent(compress(carve));
		}
	});

	btnCopy.addEventListener('click', function() {
		copyToClipboard(carveOutput.value).then(() => {
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

	convert();
})();
<?php $this->Html->scriptEnd(); ?>
