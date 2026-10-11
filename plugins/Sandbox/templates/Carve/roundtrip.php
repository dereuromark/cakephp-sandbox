<?php
/**
 * @var \App\View\AppView $this
 */

$defaultCarve = <<<'CARVE'
{#start}
# Roundtrip Test

This document is exported and imported back to check which spellings survive.

* a star-bulleted list
* with /emphasis/ and *strong* text

***

See the [Carve spec][spec] or visit <https://github.com/markup-carve>.

::: aside
A plain container with no attributes.
:::

|=< Name |=> Type |
| Carve | Markup |
| PHP | Code |

A GFM separator row is an accepted alias. Only the HTML carrier keeps it:

| Engine | Language |
|:-------|---------:|
| carve-php | PHP |

[spec]: https://github.com/markup-carve/carve
CARVE;
$markdownFormat = $this->request->getQuery('format') === 'markdown';
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Carve Roundtrip Test</h2>
<p>
	Exports Carve to HTML or Markdown and imports it back:
	<code>Carve &rarr; export &rarr; Carve</code>. Each trip runs twice, once as a plain
	export and once with the <strong>roundtrip export option</strong>
	(<code>new CarveConverter(roundTripMode: true)</code>, <code>--roundtrip</code> on the CLI),
	so you can see what the option keeps. The same option serves both formats; the target
	decides which carriers it writes.
</p>
<ul class="small">
	<li>
		<strong>HTML</strong> (spec PART 10 &sect;13):
		the export writes carrier attributes such as <code>data-marker</code>, <code>data-char</code>,
		<code>data-carve-ref</code>, <code>data-carve-autolink</code> and <code>data-carve-col-widths</code>,
		and the importer reads the authored spelling back from them.
	</li>
	<li>
		<strong>Markdown</strong> (spec PART 11 &sect;10s, &sect;10t):
		what Markdown has no spelling for is carried in <code>&lt;!-- carve: ... --&gt;</code> comments:
		containers and line blocks, attribute lines such as a heading's <code>{#id}</code>,
		definition lists and captions. The document's structure comes back; spellings Markdown
		writes its own way (marker style, reference links, autolinks) still come back normalized.
	</li>
</ul>
<p class="text-muted small">
	Carriers are highlighted in the exported source. Soft line breaks inside a paragraph and
	table cell padding are not carried in either format.
</p>

<div id="alert-container"></div>

<div class="d-flex flex-wrap align-items-center gap-3 mb-2">
	<div class="btn-group btn-group-sm" role="group" aria-label="Export format">
		<input type="radio" class="btn-check" name="format" id="format-html" value="html"<?= $markdownFormat ? '' : ' checked' ?>>
		<label class="btn btn-outline-primary" for="format-html">HTML</label>
		<input type="radio" class="btn-check" name="format" id="format-markdown" value="markdown"<?= $markdownFormat ? ' checked' : '' ?>>
		<label class="btn btn-outline-primary" for="format-markdown">Markdown</label>
	</div>
	<button type="button" class="btn btn-sm btn-outline-secondary" id="btn-share" title="Copy a link with this input and format">
		<i class="bi bi-share"></i> Share
	</button>
	<div id="status-container"></div>
	<span id="loading-indicator" style="opacity: 0;">
		<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
	</span>
</div>

<label class="form-label" for="carve-input"><strong>Carve Input</strong></label>
<textarea id="carve-input" class="form-control font-monospace mb-3" rows="16" placeholder="Enter Carve..."><?= h($defaultCarve) ?></textarea>

<div class="row">
	<?php foreach (['plain' => 'Plain export', 'roundtrip' => 'Roundtrip export'] as $key => $label) { ?>
	<div class="col-lg-6 mb-3">
		<h3 class="h5">
			<?= h($label) ?>
			<span id="verdict-<?= $key ?>" class="ms-1"></span>
		</h3>
		<div class="small text-muted mb-1">Exported <span class="format-name">HTML</span></div>
		<pre id="exported-<?= $key ?>" class="border rounded p-2 small bg-light" style="max-height: 320px; overflow: auto;"></pre>
		<div class="small text-muted mb-1">Carve after the trip <span class="text-muted">(diff against the input)</span></div>
		<pre id="diff-<?= $key ?>" class="border rounded p-2 small bg-light" style="max-height: 320px; overflow: auto;"></pre>
	</div>
	<?php } ?>
</div>

<h3 class="mt-2">Rendered HTML Preview <small class="text-muted">(first pass)</small></h3>
<div id="html-preview" class="carve-rendered border rounded p-3"></div>

</div>

<?= $this->element('carve/output_styles') ?>

<style>
.roundtrip-carrier {
	background: #fff3b0;
	color: #6b4e00;
	border-radius: 2px;
}
</style>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const carveInput = document.getElementById('carve-input');
	const alertContainer = document.getElementById('alert-container');
	const statusContainer = document.getElementById('status-container');
	const htmlPreview = document.getElementById('html-preview');
	const loadingIndicator = document.getElementById('loading-indicator');
	const formatInputs = document.querySelectorAll('input[name="format"]');
	const btnShare = document.getElementById('btn-share');

	// The reserved carrier names (PART 10 §13a) plus the Markdown comment markers.
	const carrierPattern = /(data-(?:carve|djot)-[a-z-]+(?:="[^"]*")?|data-(?:marker|char)="[^"]*"|&lt;!-- carve: .*? --&gt;)/g;

	let debounceTimer;
	let currentRequest;

	function currentFormat() {
		const checked = document.querySelector('input[name="format"]:checked');
		return checked ? checked.value : 'html';
	}

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
		formData.append('carve', carveInput.value);
		formData.append('format', currentFormat());

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

			const formatName = data.format === 'markdown' ? 'Markdown' : 'HTML';
			document.querySelectorAll('.format-name').forEach(el => { el.textContent = formatName; });

			htmlPreview.innerHTML = data.html1 || '';
			renderStatus(data);
			const input = normalizeNewlines(carveInput.value);
			for (const key of ['plain', 'roundtrip']) {
				renderExport(key, data.exports ? data.exports[key] : null, input);
			}
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
		if (data.error || data.msToHtml === null || data.msToHtml === undefined) {
			statusContainer.innerHTML = '';
			return;
		}
		statusContainer.innerHTML = '<span class="badge bg-light text-secondary border" title="Server-side time of the plain HTML pass">'
			+ '⚡ Carve&rarr;HTML ' + data.msToHtml + ' ms · HTML&rarr;Carve ' + data.msToCarve + ' ms</span>';
	}

	function renderExport(key, exp, input) {
		const exported = document.getElementById('exported-' + key);
		const diff = document.getElementById('diff-' + key);
		const verdict = document.getElementById('verdict-' + key);
		if (!exp) {
			exported.innerHTML = '';
			diff.innerHTML = '';
			verdict.innerHTML = '';
			return;
		}

		exported.innerHTML = escapeHtml(exp.exported).replace(carrierPattern, '<mark class="roundtrip-carrier">$1</mark>');

		const ops = diffLines(input.trim().split('\n'), exp.carve.trim().split('\n'));
		const changed = ops.filter(op => op.type === 'del').length;
		if (exp.carveStable) {
			verdict.innerHTML = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Identical</span>';
		} else {
			verdict.innerHTML = '<span class="badge bg-warning text-dark"><i class="bi bi-arrow-repeat"></i> '
				+ changed + ' line' + (changed === 1 ? '' : 's') + ' changed</span>';
		}

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
		diff.innerHTML = html;
	}

	function normalizeNewlines(text) {
		return text.replace(/\r\n?/g, '\n');
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

	// Same `d` encoding as the Carve playground, so links look alike.
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

	function syncFormatToUrl() {
		const url = new URL(window.location.href);
		if (currentFormat() === 'markdown') {
			url.searchParams.set('format', 'markdown');
		} else {
			url.searchParams.delete('format');
		}
		history.replaceState(null, '', url);
	}

	function getShareUrl() {
		const url = new URL(window.location.href.split('?')[0]);
		url.searchParams.set('d', compress(carveInput.value));
		if (currentFormat() === 'markdown') {
			url.searchParams.set('format', 'markdown');
		}
		return url.toString();
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
			return Promise.resolve();
		} catch (e) {
			return Promise.reject(e);
		} finally {
			document.body.removeChild(textarea);
		}
	}

	const shared = new URLSearchParams(window.location.search).get('d');
	if (shared) {
		const decoded = decompress(shared);
		if (decoded !== null) {
			carveInput.value = decoded;
		}
	}

	carveInput.addEventListener('input', convert);
	formatInputs.forEach(el => el.addEventListener('change', () => {
		syncFormatToUrl();
		convert();
	}));

	btnShare.addEventListener('click', function() {
		const shareUrl = getShareUrl();
		history.replaceState(null, '', shareUrl);
		copyToClipboard(shareUrl).then(() => {
			const originalHtml = btnShare.innerHTML;
			btnShare.innerHTML = '<i class="bi bi-check"></i> Link copied';
			btnShare.classList.replace('btn-outline-secondary', 'btn-success');
			setTimeout(() => {
				btnShare.innerHTML = originalHtml;
				btnShare.classList.replace('btn-success', 'btn-outline-secondary');
			}, 2000);
		});
	});

	// Initial conversion
	convert();
})();
<?php $this->Html->scriptEnd(); ?>
