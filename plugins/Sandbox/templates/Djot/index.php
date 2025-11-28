<?php
/**
 * @var \App\View\AppView $this
 * @var bool $debugMode
 */

$defaultDjot = <<<'DJOT'
# Djot Playground

This is a *Djot* markup demo. Try editing this text!

## Features

- _emphasis_ and *strong* text
- {=highlighted=} text
- {+inserted+} and {-deleted-} text
- Links: [Djot docs](https://djot.net)
- Inline `code` spans

### Code Block

``` php
<?php
echo "Hello, World!";
```

### Blockquote

> The best way to predict the future is to invent it.

--- _Alan Kay_

### Table

{.table}
| Name   | Type   |
|--------|--------|
| Djot   | Markup |
| PHP    | Code   |

### Lists

x. A *cool*
x. automatically *numbered*

  - sub

    - subsub

x. nested *list*

### Task List

- [ ] Write documentation
- [x] Create examples
- [x] Test features

### Definition List

Djot
: A lightweight markup language with clean syntax.

Markdown
: The predecessor that inspired Djot.

### Super/Subscript

- Superscript: 2^10^ = 1024
- Subscript: H~2~O

### Footnotes

Here is a footnote reference[^1].

[^1]: This is the footnote content.
DJOT;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<ul class="side-nav nav nav-pills nav-stacked flex-column">
		<li class="heading"><?= __('Links') ?></li>
		<li class="nav-item"><?= $this->Html->link('Djot-PHP', 'https://github.com/php-collective/djot-php', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
		<li class="nav-item"><?= $this->Html->link('Djot Spec', 'https://djot.net', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
		<li class="nav-item"><?= $this->Html->link('Cheatsheet', 'https://htmlpreview.github.io/?https://github.com/jgm/djot/blob/master/doc/cheatsheet.html', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
	</ul>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Djot Playground</h2>
<p>
	<a href="https://github.com/php-collective/djot-php" target="_blank">[Djot-PHP]</a> converts
	<a href="https://djot.net" target="_blank">Djot</a> markup to HTML.
	Edit on the left, see the result on the right.
</p>

<div class="row mb-2 align-items-center">
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-xhtml">
			<label class="form-check-label" for="opt-xhtml">XHTML</label>
		</div>
	</div>
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-warnings">
			<label class="form-check-label" for="opt-warnings">Warnings</label>
		</div>
	</div>
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-strict">
			<label class="form-check-label" for="opt-strict">Strict</label>
		</div>
	</div>
	<?php if ($debugMode) { ?>
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-raw">
			<label class="form-check-label text-danger" for="opt-raw" title="Disable HTML sanitization (debug only)">Raw</label>
		</div>
	</div>
	<?php } ?>
	<div class="col-auto ms-auto">
		<span id="loading-indicator" class="me-2" style="opacity: 0;">
			<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
		</span>
		<button type="button" class="btn btn-sm btn-outline-primary me-2" id="btn-share" title="Copy shareable link">
			<i class="bi bi-share"></i> Share
		</button>
		<div class="btn-group btn-group-sm" role="group">
			<input type="radio" class="btn-check" name="view-mode" id="view-rendered" value="rendered" checked>
			<label class="btn btn-outline-secondary" for="view-rendered">Preview</label>
			<input type="radio" class="btn-check" name="view-mode" id="view-source" value="source">
			<label class="btn btn-outline-secondary" for="view-source">HTML</label>
		</div>
	</div>
</div>

<div id="alert-container"></div>

<style>
#output-rendered ul.task-list,
#output-rendered ul.task {
	list-style: none;
	padding-left: 0;
}
#output-rendered ul.task-list li,
#output-rendered ul.task li {
	padding-left: 1.5em;
	text-indent: -1.5em;
}
</style>

<div class="row">
	<div class="col-md-6">
		<textarea id="djot-input" class="form-control font-monospace" rows="20" placeholder="Enter Djot markup..."><?= h($defaultDjot) ?></textarea>
	</div>
	<div class="col-md-6">
		<div id="output-rendered" class="border rounded p-3 bg-white" style="min-height: 100%; max-height: 480px; overflow-y: auto;"></div>
		<pre id="output-source" class="border rounded p-3 bg-light d-none" style="min-height: 100%; max-height: 480px; overflow-y: auto; margin: 0;"><code></code></pre>
	</div>
</div>

<p class="text-muted small mt-2">
	<i class="bi bi-shield-check"></i>
	Output is sanitized via <a href="https://github.com/ezyang/htmlpurifier" target="_blank">HTMLPurifier</a> for security.
	For raw output, clone the <a href="https://github.com/dereuromark/cakephp-sandbox" target="_blank">sandbox repo</a> and run locally in debug mode.
</p>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const input = document.getElementById('djot-input');
	const outputRendered = document.getElementById('output-rendered');
	const outputSource = document.getElementById('output-source');
	const alertContainer = document.getElementById('alert-container');
	const loadingIndicator = document.getElementById('loading-indicator');
	const optXhtml = document.getElementById('opt-xhtml');
	const optWarnings = document.getElementById('opt-warnings');
	const optStrict = document.getElementById('opt-strict');
	const optRaw = document.getElementById('opt-raw');
	const viewRendered = document.getElementById('view-rendered');
	const viewSource = document.getElementById('view-source');
	const btnShare = document.getElementById('btn-share');

	let debounceTimer;
	let currentRequest;

	function compress(str) {
		return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, (match, p1) => String.fromCharCode('0x' + p1)));
	}

	function decompress(str) {
		try {
			return decodeURIComponent(atob(str).split('').map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)).join(''));
		} catch (e) {
			return null;
		}
	}

	function loadFromUrl() {
		const params = new URLSearchParams(window.location.search);
		const encoded = params.get('d');
		if (encoded) {
			const decoded = decompress(encoded);
			if (decoded) {
				input.value = decoded;
			}
		}
		if (params.get('xhtml') === '1') optXhtml.checked = true;
		if (params.get('warnings') === '1') optWarnings.checked = true;
		if (params.get('strict') === '1') optStrict.checked = true;
	}

	function getShareUrl() {
		const url = new URL(window.location.href.split('?')[0]);
		url.searchParams.set('d', compress(input.value));
		if (optXhtml.checked) url.searchParams.set('xhtml', '1');
		if (optWarnings.checked) url.searchParams.set('warnings', '1');
		if (optStrict.checked) url.searchParams.set('strict', '1');
		return url.toString();
	}

	function copyToClipboard(text) {
		if (navigator.clipboard && navigator.clipboard.writeText) {
			return navigator.clipboard.writeText(text);
		}
		// Fallback for HTTP
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

	function share() {
		const url = getShareUrl();
		copyToClipboard(url).then(() => {
			const originalHtml = btnShare.innerHTML;
			btnShare.innerHTML = '<i class="bi bi-check"></i> Copied!';
			btnShare.classList.remove('btn-outline-primary');
			btnShare.classList.add('btn-success');
			setTimeout(() => {
				btnShare.innerHTML = originalHtml;
				btnShare.classList.remove('btn-success');
				btnShare.classList.add('btn-outline-primary');
			}, 2000);
		}).catch(() => {
			prompt('Copy this URL:', url);
		});
	}

	function convert() {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(doConvert, 150);
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
		formData.append('djot', input.value);
		formData.append('xhtml', optXhtml.checked ? '1' : '0');
		formData.append('warnings', optWarnings.checked ? '1' : '0');
		formData.append('strict', optStrict.checked ? '1' : '0');
		formData.append('raw', optRaw && optRaw.checked ? '1' : '0');

		fetch('<?= $this->Url->build(['action' => 'convert']) ?>', {
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

			if (data.warnings && data.warnings.length > 0) {
				let warningHtml = '<div class="alert alert-warning py-2"><strong>Warnings:</strong><ul class="mb-0 ps-3">';
				data.warnings.forEach(function(w) {
					warningHtml += '<li>' + escapeHtml(w.message) + ' (line ' + w.line + ')</li>';
				});
				warningHtml += '</ul></div>';
				alertContainer.innerHTML += warningHtml;
			}

			outputRendered.innerHTML = data.html || '<span class="text-muted">Enter some Djot markup...</span>';
			outputSource.querySelector('code').textContent = data.html || '';
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

	function updateView() {
		if (viewSource.checked) {
			outputRendered.classList.add('d-none');
			outputSource.classList.remove('d-none');
		} else {
			outputRendered.classList.remove('d-none');
			outputSource.classList.add('d-none');
		}
	}

	input.addEventListener('input', convert);
	optXhtml.addEventListener('change', convert);
	optWarnings.addEventListener('change', convert);
	optStrict.addEventListener('change', convert);
	if (optRaw) optRaw.addEventListener('change', convert);
	viewRendered.addEventListener('change', updateView);
	viewSource.addEventListener('change', updateView);
	btnShare.addEventListener('click', share);

	// Load from URL if shared, then convert
	loadFromUrl();
	convert();
})();
<?php $this->Html->scriptEnd(); ?>
