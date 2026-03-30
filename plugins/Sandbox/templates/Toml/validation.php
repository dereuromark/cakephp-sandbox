<?php
/**
 * @var \App\View\AppView $this
 */

echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/toml.min.js');

$defaultToml = <<<'TOML'
# TOML Validation Demo
# This file has intentional errors - fix them!

title = "Validation Test"

# Error: Duplicate key
name = "First"
name = "Second"

# Error: Invalid date format
bad_date = 2024-13-45

# Error: Unclosed string
unclosed = "hello

# Error: Invalid number
bad_number = 1.2.3

[server]
host = "localhost"
port = 8080
TOML;

$errorExamples = [
	'Duplicate Keys' => [
		'description' => 'TOML does not allow duplicate keys in the same table.',
		'code' => <<<'TOML'
name = "Alice"
name = "Bob"
TOML,
	],
	'Invalid Date' => [
		'description' => 'Date values must follow RFC 3339 format.',
		'code' => <<<'TOML'
# Invalid month (13)
date = 2024-13-01

# Invalid day (32)
another = 2024-01-32
TOML,
	],
	'Unclosed String' => [
		'description' => 'Strings must be properly closed.',
		'code' => <<<'TOML'
message = "Hello World
name = "Test"
TOML,
	],
	'Invalid Table' => [
		'description' => 'Table names must be valid.',
		'code' => <<<'TOML'
[]
key = "empty table name not allowed"

[a.b.c]
x = 1

[a]
# Error: cannot define [a] after [a.b.c]
y = 2
TOML,
	],
	'Type Mismatch' => [
		'description' => 'Cannot redefine a key with a different type.',
		'code' => <<<'TOML'
[fruit]
apple = 1

[fruit.apple]
# Error: apple was already defined as integer
color = "red"
TOML,
	],
	'Invalid Number Format' => [
		'description' => 'Numbers must follow TOML number syntax.',
		'code' => <<<'TOML'
# Multiple decimal points
bad1 = 1.2.3

# Leading zeros not allowed
bad2 = 007

# Underscore placement
bad3 = _1000
bad4 = 1000_
TOML,
	],
];
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/toml') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>TOML Validation</h2>
<p>
	Test TOML validation with error recovery. The parser collects all errors instead of stopping at the first one.
	This is useful for linting tools and editor integrations.
</p>

<div id="alert-container"></div>

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
.line-numbers div.highlighted {
	background: #fff3cd;
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
.error-badge {
	cursor: pointer;
}
.error-badge:hover {
	opacity: 0.8;
}
</style>

<div class="row mb-3">
	<div class="col-md-6">
		<label class="form-label">TOML Input</label>
		<div class="editor-container">
			<div class="line-numbers" id="line-numbers"></div>
			<textarea id="toml-input" class="form-control font-monospace" rows="15" placeholder="Enter TOML to validate..."><?= h($defaultToml) ?></textarea>
		</div>
		<button type="button" class="btn btn-primary mt-2" id="btn-validate">
			<i class="bi bi-check-circle"></i> Validate
		</button>
	</div>
	<div class="col-md-6">
		<label class="form-label">Validation Result</label>
		<div id="validation-result" class="border rounded p-3 bg-light" style="min-height: 350px;">
			<span class="text-muted">Click "Validate" to check the TOML...</span>
		</div>
	</div>
</div>

<h3>Common TOML Errors</h3>
<p class="text-muted">Click "Try it" to load examples with intentional errors:</p>

<div class="row">
<?php foreach ($errorExamples as $title => $example) { ?>
<div class="col-md-6 mb-3">
	<div class="card">
		<div class="card-header d-flex justify-content-between align-items-center py-2">
			<strong><?= h($title) ?></strong>
			<button type="button" class="btn btn-sm btn-outline-danger try-error" data-code="<?= h($example['code']) ?>">
				<i class="bi bi-bug"></i> Try
			</button>
		</div>
		<div class="card-body py-2">
			<p class="text-muted small mb-2"><?= h($example['description']) ?></p>
			<pre class="bg-light p-2 border rounded mb-0"><code class="language-toml"><?= h($example['code']) ?></code></pre>
		</div>
	</div>
</div>
<?php } ?>
</div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const input = document.getElementById('toml-input');
	const lineNumbers = document.getElementById('line-numbers');
	const result = document.getElementById('validation-result');
	const alertContainer = document.getElementById('alert-container');
	const btnValidate = document.getElementById('btn-validate');

	let errorLines = [];

	function updateLineNumbers() {
		const lines = input.value.split('\n');
		let html = '';
		for (let i = 1; i <= lines.length; i++) {
			const isError = errorLines.includes(i);
			html += '<div' + (isError ? ' class="error-line"' : '') + '>' + i + '</div>';
		}
		lineNumbers.innerHTML = html;
	}

	function syncScroll() {
		lineNumbers.scrollTop = input.scrollTop;
	}

	function goToLine(lineNum) {
		const lines = input.value.split('\n');
		let charIndex = 0;
		for (let i = 0; i < lineNum - 1 && i < lines.length; i++) {
			charIndex += lines[i].length + 1;
		}
		input.focus();
		input.setSelectionRange(charIndex, charIndex + (lines[lineNum - 1]?.length || 0));

		// Scroll line into view
		const lineHeight = input.scrollHeight / lines.length;
		const targetScroll = (lineNum - 5) * lineHeight;
		input.scrollTop = Math.max(0, targetScroll);

		// Briefly highlight the line number
		const lineEl = lineNumbers.children[lineNum - 1];
		if (lineEl) {
			lineEl.classList.add('highlighted');
			setTimeout(() => lineEl.classList.remove('highlighted'), 1500);
		}
	}

	function validate() {
		result.innerHTML = '<span class="text-muted">Validating...</span>';
		alertContainer.innerHTML = '';
		errorLines = [];
		updateLineNumbers();

		const formData = new FormData();
		formData.append('toml', input.value);

		fetch('<?= $this->Url->build(['action' => 'validate']) ?>', {
			method: 'POST',
			body: formData,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		.then(response => response.json())
		.then(data => {
			if (data.valid) {
				result.innerHTML = '<div class="alert alert-success mb-2"><i class="bi bi-check-circle-fill"></i> Valid TOML!</div>' +
					'<pre class="mb-0"><code>' + escapeHtml(JSON.stringify(data.data, null, 2)) + '</code></pre>';
			} else if (data.errors && data.errors.length > 0) {
				errorLines = data.errors.filter(e => e.line).map(e => e.line);
				updateLineNumbers();

				const inputLines = input.value.split('\n');
				let html = '<div class="alert alert-danger mb-2"><i class="bi bi-x-circle-fill"></i> ' + data.errors.length + ' error(s) found</div>';
				html += '<ul class="list-group">';
				data.errors.forEach(function(err, i) {
					html += '<li class="list-group-item list-group-item-danger">';
					html += '<strong>Error ' + (i + 1) + ':</strong> ' + escapeHtml(err.message);
					if (err.line) {
						html += ' <span class="badge bg-secondary error-badge" data-line="' + err.line + '" title="Click to go to line">Line ' + err.line;
						if (err.column) html += ':' + err.column;
						html += '</span>';
					}
					if (err.hint) {
						html += '<div class="text-muted small mt-1"><i class="bi bi-lightbulb text-warning"></i> ' + escapeHtml(err.hint) + '</div>';
					}
					if (err.line) {
						// Show context: the actual line content
						const lineIdx = err.line - 1;
						if (lineIdx >= 0 && lineIdx < inputLines.length) {
							const lineContent = inputLines[lineIdx];
							html += '<pre class="mt-2 mb-0 p-2 bg-white border rounded small"><code>';
							// Show line number prefix
							html += '<span class="text-muted">' + err.line.toString().padStart(3) + ' │ </span>';
							html += escapeHtml(lineContent || '(empty line)');
							// Show column indicator if available
							if (err.column && err.column > 0) {
								html += '\n<span class="text-muted">      </span><span class="text-danger">' + ' '.repeat(err.column) + '^</span>';
							}
							html += '</code></pre>';
						}
					}
					html += '</li>';
				});
				html += '</ul>';
				result.innerHTML = html;

				// Add click handlers to error badges
				result.querySelectorAll('.error-badge').forEach(badge => {
					badge.addEventListener('click', function() {
						goToLine(parseInt(this.dataset.line, 10));
					});
				});
			} else {
				result.innerHTML = '<span class="text-muted">No result</span>';
			}
		})
		.catch(err => {
			console.error('Validation error:', err);
			result.innerHTML = '<div class="alert alert-danger">Request failed</div>';
		});
	}

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	btnValidate.addEventListener('click', validate);
	input.addEventListener('input', function() {
		errorLines = [];
		updateLineNumbers();
	});
	input.addEventListener('scroll', syncScroll);

	// Try error examples
	document.querySelectorAll('.try-error').forEach(btn => {
		btn.addEventListener('click', function() {
			input.value = this.dataset.code;
			errorLines = [];
			updateLineNumbers();
			input.scrollIntoView({ behavior: 'smooth', block: 'center' });
			validate();
		});
	});

	// Initialize syntax highlighting
	document.querySelectorAll('code.language-toml').forEach(el => {
		hljs.highlightElement(el);
	});

	// Initialize line numbers
	updateLineNumbers();
})();
<?php $this->Html->scriptEnd(); ?>
