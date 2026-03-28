<?php
/**
 * @var \App\View\AppView $this
 * @var string $exampleNeon
 */

$this->assign('title', 'Workflow Builder');
?>

<style>
	.builder-container {
		display: flex;
		gap: 20px;
		height: calc(100vh - 250px);
		min-height: 500px;
	}
	.editor-panel {
		flex: 1;
		display: flex;
		flex-direction: column;
	}
	.preview-panel {
		flex: 1;
		display: flex;
		flex-direction: column;
	}
	#editor {
		flex: 1;
		border: 1px solid #dee2e6;
		border-radius: 4px;
	}
	#preview {
		flex: 1;
		border: 1px solid #dee2e6;
		border-radius: 4px;
		padding: 20px;
		overflow: auto;
		background: #f8f9fa;
	}
	.status-bar {
		padding: 8px;
		background: #e9ecef;
		border-radius: 0 0 4px 4px;
		font-size: 0.875rem;
	}
	.status-bar.error {
		background: #f8d7da;
		color: #721c24;
	}
	.status-bar.success {
		background: #d4edda;
		color: #155724;
	}
	.example-buttons {
		display: flex;
		gap: 5px;
		flex-wrap: wrap;
	}
</style>

<div class="row mb-3">
	<div class="col-md-8">
		<h1>Interactive Workflow Builder</h1>
		<p class="text-muted">Edit NEON workflow definitions and see live diagram updates.</p>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back to Overview', ['controller' => 'WorkflowSandbox', 'action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
	</div>
</div>

<div class="card mb-3">
	<div class="card-body py-2">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				<strong>Load Example:</strong>
				<div class="example-buttons d-inline-flex ms-2">
					<button class="btn btn-sm btn-outline-primary" onclick="loadExample('registration')">Registration</button>
					<button class="btn btn-sm btn-outline-primary" onclick="loadExample('order')">Order</button>
					<button class="btn btn-sm btn-outline-primary" onclick="loadExample('content')">Content</button>
					<button class="btn btn-sm btn-outline-primary" onclick="loadExample('ticket')">Ticket</button>
					<button class="btn btn-sm btn-outline-primary" onclick="loadExample('document')">Document</button>
				</div>
			</div>
			<div>
				<button class="btn btn-sm btn-success" onclick="downloadNeon()">
					<i class="fas fa-download"></i> Download NEON
				</button>
			</div>
		</div>
	</div>
</div>

<div class="builder-container">
	<div class="editor-panel">
		<h5>NEON Editor</h5>
		<div id="editor"></div>
		<div id="status" class="status-bar">Ready. Edit the NEON to see live preview.</div>
	</div>

	<div class="preview-panel">
		<h5>Workflow Diagram</h5>
		<div id="preview">
			<div class="text-center text-muted py-5">
				<p>Loading preview...</p>
			</div>
		</div>
		<div id="info" class="status-bar">
			<span id="workflow-info"></span>
		</div>
	</div>
</div>

<!-- Mermaid (loaded first, before AMD loader) -->
<script src="https://cdn.jsdelivr.net/npm/mermaid@10.9.5/dist/mermaid.min.js"></script>

<script>
// Initialize Mermaid immediately
mermaid.initialize({
	startOnLoad: false,
	theme: 'default',
	securityLevel: 'loose'
});
</script>

<!-- Monaco Editor (AMD loader after Mermaid) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs/loader.min.js"></script>

<script>
let editor;
let debounceTimer;

// Initialize Monaco Editor
require.config({ paths: { vs: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs' } });

require(['vs/editor/editor.main'], function () {
	// Register NEON as YAML (close enough syntax)
	monaco.languages.register({ id: 'neon' });
	monaco.languages.setMonarchTokensProvider('neon', {
		tokenizer: {
			root: [
				[/#.*$/, 'comment'],
				[/[a-zA-Z_][\w]*(?=:)/, 'key'],
				[/:\s*/, 'delimiter'],
				[/"([^"\\]|\\.)*"/, 'string'],
				[/'([^'\\]|\\.)*'/, 'string'],
				[/\btrue\b|\bfalse\b/, 'keyword'],
				[/\bnull\b/, 'keyword'],
				[/-?\d+\.?\d*/, 'number'],
				[/[\[\]{}]/, 'bracket'],
			]
		}
	});

	editor = monaco.editor.create(document.getElementById('editor'), {
		value: <?= json_encode($exampleNeon) ?>,
		language: 'yaml',
		theme: 'vs',
		automaticLayout: true,
		minimap: { enabled: false },
		fontSize: 14,
		lineNumbers: 'on',
		scrollBeyondLastLine: false,
		wordWrap: 'on'
	});

	// Live preview on change
	editor.onDidChangeModelContent(function () {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(updatePreview, 500);
	});

	// Initial preview
	updatePreview();
});

function updatePreview() {
	const neon = editor.getValue();
	const statusEl = document.getElementById('status');
	const previewEl = document.getElementById('preview');
	const infoEl = document.getElementById('workflow-info');

	statusEl.className = 'status-bar';
	statusEl.textContent = 'Updating preview...';

	fetch('<?= $this->Url->build(['action' => 'preview']) ?>', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
			'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>'
		},
		body: 'neon=' + encodeURIComponent(neon)
	})
	.then(response => response.json())
	.then(data => {
		if (data.success) {
			statusEl.className = 'status-bar success';
			statusEl.textContent = 'Valid workflow definition';

			infoEl.textContent = `Workflow: ${data.info.name} | States: ${data.info.states} | Transitions: ${data.info.transitions}`;

			// Render Mermaid diagram
			previewEl.innerHTML = '<pre class="mermaid">' + data.mermaid + '</pre>';
			mermaid.run({ nodes: previewEl.querySelectorAll('.mermaid') });
		} else {
			statusEl.className = 'status-bar error';
			statusEl.textContent = 'Error: ' + data.error;
			infoEl.textContent = '';
		}
	})
	.catch(err => {
		statusEl.className = 'status-bar error';
		statusEl.textContent = 'Network error: ' + err.message;
	});
}

function loadExample(name) {
	fetch('<?= $this->Url->build(['action' => 'loadExample']) ?>/' + name)
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				editor.setValue(data.neon);
			} else {
				alert('Failed to load example: ' + data.error);
			}
		})
		.catch(err => alert('Error: ' + err.message));
}

function downloadNeon() {
	const neon = editor.getValue();
	const blob = new Blob([neon], { type: 'text/plain' });
	const url = URL.createObjectURL(blob);
	const a = document.createElement('a');
	a.href = url;
	a.download = 'workflow.neon';
	document.body.appendChild(a);
	a.click();
	document.body.removeChild(a);
	URL.revokeObjectURL(url);
}
</script>
