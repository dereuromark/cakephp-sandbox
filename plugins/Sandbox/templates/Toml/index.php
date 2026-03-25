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
	</div>
</div>

<div id="alert-container"></div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label" id="input-label">TOML Input</label>
		<textarea id="toml-input" class="form-control font-monospace" rows="20" placeholder="Enter TOML..."><?= h($defaultToml) ?></textarea>
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
	const output = document.getElementById('output').querySelector('code');
	const alertContainer = document.getElementById('alert-container');
	const loadingIndicator = document.getElementById('loading-indicator');
	const modeDecode = document.getElementById('mode-decode');
	const modeEncode = document.getElementById('mode-encode');
	const inputLabel = document.getElementById('input-label');
	const outputLabel = document.getElementById('output-label');

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
				alertContainer.innerHTML = '<div class="alert alert-danger py-2"><strong>Error:</strong> ' + escapeHtml(data.error) + '</div>';
				output.textContent = '';
			} else if (data.success) {
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
		convert();
	}

	function loadFromUrl() {
		const params = new URLSearchParams(window.location.search);
		const encoded = params.get('d');
		if (encoded) {
			try {
				input.value = atob(encoded);
			} catch (e) {
				console.error('Failed to decode URL parameter');
			}
		}
	}

	input.addEventListener('input', convert);
	modeDecode.addEventListener('change', updateMode);
	modeEncode.addEventListener('change', updateMode);

	loadFromUrl();
	convert();
})();
<?php $this->Html->scriptEnd(); ?>
