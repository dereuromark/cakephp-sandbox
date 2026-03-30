<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $tomlVersion
 */

$defaultToml = <<<'TOML'
# TOML Playground
# Edit on the left, see the result on the right

title = "TOML Example"
description = "A minimal TOML configuration"

[owner]
name = "Tom Preston-Werner"
dob = 1979-05-27T07:32:00-08:00

[database]
enabled = true
ports = [8000, 8001, 8002]
data = [["delta", "phi"], [3.14]]
temp_targets = { cpu = 79.5, case = 72.0 }

[servers]

[servers.alpha]
ip = "10.0.0.1"
role = "frontend"

[servers.beta]
ip = "10.0.0.2"
role = "backend"
TOML;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/toml') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>TOML Playground</h2>
<p>
	<a href="https://github.com/php-collective/toml" target="_blank">[TOML-PHP<?php if ($tomlVersion) { ?> <?= h($tomlVersion) ?><?php } ?>]</a> parses and encodes
	<a href="https://toml.io" target="_blank">TOML</a> configuration files.
	Edit on the left, see the result on the right.
</p>

<div class="row mb-2 align-items-center">
	<div class="col-auto">
		<div class="btn-group btn-group-sm" role="group">
			<input type="radio" class="btn-check" name="mode" id="mode-decode" value="decode" checked>
			<label class="btn btn-outline-primary" for="mode-decode">TOML → PHP</label>
			<input type="radio" class="btn-check" name="mode" id="mode-encode" value="encode">
			<label class="btn btn-outline-primary" for="mode-encode">JSON → TOML</label>
		</div>
	</div>
	<div class="col-auto ms-auto">
		<span id="loading-indicator" class="me-2" style="opacity: 0;">
			<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
		</span>
		<button type="button" class="btn btn-sm btn-outline-primary" id="btn-share" title="Copy shareable link">
			<i class="bi bi-share"></i> Share
		</button>
	</div>
</div>

<style>
.editor-container {
	display: flex;
	border: 1px solid #dee2e6;
	border-radius: 0.375rem;
	overflow: hidden;
}
.line-numbers {
	background: #f8f9fa;
	border-right: 1px solid #dee2e6;
	padding: 0.375rem 0;
	text-align: right;
	user-select: none;
	font-family: monospace;
	font-size: 0.875rem;
	line-height: 1.5;
	color: #6c757d;
	min-width: 3em;
}
.line-numbers div {
	padding: 0 0.5rem;
}
.line-numbers div.error-line {
	background: #f8d7da;
	color: #842029;
	font-weight: bold;
}
#toml-input {
	border: none;
	border-radius: 0;
	resize: none;
	line-height: 1.5;
	font-size: 0.875rem;
}
#toml-input:focus {
	box-shadow: none;
}
</style>

<div id="alert-container"></div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label" id="input-label">TOML Input</label>
		<div class="editor-container">
			<div class="line-numbers" id="line-numbers"></div>
			<textarea id="toml-input" class="form-control font-monospace" rows="20" placeholder="Enter TOML..."><?= h($defaultToml) ?></textarea>
		</div>
	</div>
	<div class="col-md-6">
		<label class="form-label" id="output-label">PHP Array (JSON)</label>
		<pre id="output" class="border rounded p-3 bg-light" style="min-height: 480px; max-height: 480px; overflow-y: auto; margin: 0;"><code></code></pre>
	</div>
</div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const input = document.getElementById('toml-input');
	const lineNumbers = document.getElementById('line-numbers');
	const output = document.getElementById('output').querySelector('code');
	const alertContainer = document.getElementById('alert-container');
	const loadingIndicator = document.getElementById('loading-indicator');
	const modeDecode = document.getElementById('mode-decode');
	const modeEncode = document.getElementById('mode-encode');

	let errorLine = null;

	function updateLineNumbers() {
		const lines = input.value.split('\n');
		let html = '';
		for (let i = 1; i <= lines.length; i++) {
			const isError = errorLine === i;
			html += '<div' + (isError ? ' class="error-line"' : '') + '>' + i + '</div>';
		}
		lineNumbers.innerHTML = html;
	}

	function syncScroll() {
		lineNumbers.scrollTop = input.scrollTop;
	}
	const inputLabel = document.getElementById('input-label');
	const outputLabel = document.getElementById('output-label');
	const btnShare = document.getElementById('btn-share');

	const defaultToml = <?= json_encode($defaultToml) ?>;
	const defaultJson = JSON.stringify({
		title: "TOML Example",
		owner: { name: "Example User" },
		database: { enabled: true, ports: [8000, 8001] }
	}, null, 2);

	let debounceTimer;
	let currentRequest;

	function getMode() {
		return modeEncode.checked ? 'encode' : 'decode';
	}

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

	function getShareUrl() {
		const url = new URL(window.location.href.split('?')[0]);
		url.searchParams.set('d', compress(input.value));
		if (getMode() === 'encode') {
			url.searchParams.set('mode', 'encode');
		}
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
		const mode = getMode();

		if (mode === 'decode') {
			formData.append('toml', input.value);
		} else {
			formData.append('json', input.value);
		}

		const url = mode === 'decode'
			? '<?= $this->Url->build(['action' => 'convert']) ?>'
			: '<?= $this->Url->build(['action' => 'encode']) ?>';

		fetch(url, {
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
				errorLine = data.line || null;
				updateLineNumbers();

				let errorHtml = '<div class="alert alert-danger py-2"><strong>Error:</strong> ' + escapeHtml(data.error);
				if (data.line) {
					errorHtml += ' <span class="badge bg-secondary">Line ' + data.line;
					if (data.column) errorHtml += ':' + data.column;
					errorHtml += '</span>';
				}
				if (data.hint) {
					errorHtml += '<div class="mt-1 small"><i class="bi bi-lightbulb text-warning"></i> ' + escapeHtml(data.hint) + '</div>';
				}
				errorHtml += '</div>';
				alertContainer.innerHTML = errorHtml;
				output.textContent = '';
			} else if (data.success) {
				errorLine = null;
				updateLineNumbers();

				if (mode === 'decode') {
					output.textContent = JSON.stringify(data.data, null, 2);
				} else {
					output.textContent = data.data;
				}
			}
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

	function updateMode() {
		const mode = getMode();
		if (mode === 'decode') {
			inputLabel.textContent = 'TOML Input';
			outputLabel.textContent = 'PHP Array (JSON)';
			input.placeholder = 'Enter TOML...';
			input.value = defaultToml;
		} else {
			inputLabel.textContent = 'JSON Input';
			outputLabel.textContent = 'TOML Output';
			input.placeholder = 'Enter JSON...';
			input.value = defaultJson;
		}
		errorLine = null;
		updateLineNumbers();
		convert();
	}

	function loadFromUrl() {
		const params = new URLSearchParams(window.location.search);
		const mode = params.get('mode');
		if (mode === 'encode') {
			modeEncode.checked = true;
			inputLabel.textContent = 'JSON Input';
			outputLabel.textContent = 'TOML Output';
			input.placeholder = 'Enter JSON...';
		}
		const encoded = params.get('d');
		if (encoded) {
			const decoded = decompress(encoded);
			if (decoded) {
				input.value = decoded;
			}
		}
	}

	input.addEventListener('input', function() {
		errorLine = null;
		updateLineNumbers();
		convert();
	});
	input.addEventListener('scroll', syncScroll);
	modeDecode.addEventListener('change', updateMode);
	modeEncode.addEventListener('change', updateMode);
	btnShare.addEventListener('click', share);

	loadFromUrl();
	updateLineNumbers();
	convert();
})();
<?php $this->Html->scriptEnd(); ?>
