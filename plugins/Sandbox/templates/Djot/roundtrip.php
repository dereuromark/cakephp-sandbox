<?php
/**
 * @var \App\View\AppView $this
 * @var bool $debugMode
 */

$defaultDjot = <<<'DJOT'
# Roundtrip Test

This document is converted to _HTML_ and back to *Djot* to check for drift.

## Features

- _emphasis_ and *strong* text
- Links: [Djot docs](https://djot.net)
- Inline `code` spans

> A blockquote with a single line.

``` php
echo "Hello, World!";
```

| Name | Type |
|------|------|
| Djot | Markup |
| PHP  | Code |
DJOT;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Djot Roundtrip Test</h2>
<p>
	Checks whether Djot survives a conversion to
	<a href="https://html.spec.whatwg.org/" target="_blank">HTML</a> and back:
	<code>Djot &rarr; HTML &rarr; Djot &rarr; HTML</code>.
	Useful when building WYSIWYG tooling that serializes content to HTML.
</p>
<p class="text-muted small">
	The Djot text is normalized on the way back (marker styles, whitespace), so an exact
	text match is the strict case. The meaningful signal is <strong>HTML stability</strong>:
	the HTML after the roundtrip matches the first-pass HTML.
</p>

<div id="alert-container"></div>

<div id="status-container" class="mb-3"></div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label"><strong>Djot Input</strong></label>
		<textarea id="djot-input" class="form-control font-monospace" rows="20" placeholder="Enter Djot..."><?= h($defaultDjot) ?></textarea>
	</div>
	<div class="col-md-6">
		<div class="d-flex justify-content-between align-items-center mb-1">
			<label class="form-label mb-0"><strong>Djot After Roundtrip</strong></label>
			<div>
				<span id="loading-indicator" class="me-2" style="opacity: 0;">
					<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
				</span>
				<button type="button" class="btn btn-sm btn-outline-secondary" id="btn-copy" title="Copy roundtrip Djot">
					<i class="bi bi-clipboard"></i> Copy
				</button>
			</div>
		</div>
		<textarea id="djot-output" class="form-control font-monospace" rows="20" readonly placeholder="Roundtrip Djot will appear here..."></textarea>
	</div>
</div>

<h3 class="mt-4">Line Diff <small class="text-muted">(input vs. roundtrip)</small></h3>
<pre id="diff-output" class="border rounded p-2 small bg-light" style="max-height: 300px; overflow: auto;"><span class="text-muted">No differences yet.</span></pre>

<h3 class="mt-4">Rendered HTML Preview <small class="text-muted">(first pass)</small></h3>
<div id="html-preview" class="border rounded p-3"></div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const djotInput = document.getElementById('djot-input');
	const djotOutput = document.getElementById('djot-output');
	const alertContainer = document.getElementById('alert-container');
	const statusContainer = document.getElementById('status-container');
	const diffOutput = document.getElementById('diff-output');
	const htmlPreview = document.getElementById('html-preview');
	const loadingIndicator = document.getElementById('loading-indicator');
	const btnCopy = document.getElementById('btn-copy');

	let debounceTimer;
	let currentRequest;

	function convert() {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(doConvert, 250);
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

		fetch('<?= $this->Url->build(['action' => 'convertRoundtrip']) ?>', {
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

			djotOutput.value = data.djot2 || '';
			htmlPreview.innerHTML = data.html1 || '';
			renderStatus(data);
			renderDiff(djotInput.value, data.djot2 || '');
		})
		.catch(err => {
			loadingIndicator.style.transition = 'opacity 0.8s';
			loadingIndicator.style.opacity = '0';
			if (err.name !== 'AbortError') {
				console.error('Roundtrip error:', err);
			}
		});
	}

	function renderStatus(data) {
		if (data.error) {
			statusContainer.innerHTML = '';
			return;
		}
		let badge;
		if (data.htmlStable && data.djotStable) {
			badge = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Stable roundtrip</span>'
				+ ' <span class="text-muted small">Djot text and HTML both identical after the roundtrip.</span>';
		} else if (data.htmlStable) {
			badge = '<span class="badge bg-warning text-dark"><i class="bi bi-arrow-repeat"></i> HTML stable, Djot normalized</span>'
				+ ' <span class="text-muted small">Renders identically; Djot text was normalized (markers/whitespace).</span>';
		} else {
			badge = '<span class="badge bg-danger"><i class="bi bi-exclamation-triangle"></i> Drift detected</span>'
				+ ' <span class="text-muted small">Second-pass HTML differs from the first - the roundtrip is lossy here.</span>';
		}
		statusContainer.innerHTML = badge;
	}

	function renderDiff(a, b) {
		if (a.trim() === b.trim()) {
			diffOutput.innerHTML = '<span class="text-success">No differences (input and roundtrip Djot are identical).</span>';
			return;
		}
		const aLines = a.split('\n');
		const bLines = b.split('\n');
		const ops = diffLines(aLines, bLines);
		let html = '';
		for (const op of ops) {
			if (op.type === 'eq') {
				html += '<div>&nbsp;&nbsp;' + escapeHtml(op.line) + '</div>';
			} else if (op.type === 'del') {
				html += '<div class="text-danger">- ' + escapeHtml(op.line) + '</div>';
			} else {
				html += '<div class="text-success">+ ' + escapeHtml(op.line) + '</div>';
			}
		}
		diffOutput.innerHTML = html;
	}

	// Longest-common-subsequence line diff so unchanged lines stay aligned
	// instead of producing spurious +/- pairs when lines are inserted/removed.
	function diffLines(a, b) {
		const n = a.length;
		const m = b.length;
		const dp = [];
		for (let i = 0; i <= n; i++) {
			dp[i] = new Array(m + 1).fill(0);
		}
		for (let i = n - 1; i >= 0; i--) {
			for (let j = m - 1; j >= 0; j--) {
				dp[i][j] = a[i] === b[j]
					? dp[i + 1][j + 1] + 1
					: Math.max(dp[i + 1][j], dp[i][j + 1]);
			}
		}
		const ops = [];
		let i = 0;
		let j = 0;
		while (i < n && j < m) {
			if (a[i] === b[j]) {
				ops.push({type: 'eq', line: a[i]});
				i++;
				j++;
			} else if (dp[i + 1][j] >= dp[i][j + 1]) {
				ops.push({type: 'del', line: a[i]});
				i++;
			} else {
				ops.push({type: 'add', line: b[j]});
				j++;
			}
		}
		while (i < n) {
			ops.push({type: 'del', line: a[i]});
			i++;
		}
		while (j < m) {
			ops.push({type: 'add', line: b[j]});
			j++;
		}

		return ops;
	}

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text === null ? '' : text;
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

	djotInput.addEventListener('input', convert);

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
