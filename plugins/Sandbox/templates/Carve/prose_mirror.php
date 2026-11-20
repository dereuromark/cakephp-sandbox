<?php
/**
 * @var \App\View\AppView $this
 * @var bool $debugMode
 */

$defaultCarve = <<<'CARVE'
= ProseMirror bridge

A paragraph with *strong*, /emphasis/, `code` and a [link](https://example.org).

- a bullet
- another one

1. first
2. second

- [x] a done task
- [ ] an open task

> A blockquote.

```php
echo 'fenced code';
```

Editorial marks travel as marks: {+inserted+} and {-deleted-}.

|= Name |= Qty |
| Apples | 3 |

{.note}
::: aside
A div with a class, kept in the `carve` attribute.
:::

A footnote[^1] and a [denied link](javascript:alert(1)).

[^1]: The note text.
CARVE;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>ProseMirror Bridge <small class="text-muted">(server-side)</small></h2>
<p>
	Carve <i class="bi bi-arrow-right"></i> ProseMirror document
	<i class="bi bi-arrow-right"></i> Carve, done entirely by
	<strong>carve-php</strong>. No Node runtime is involved, so a
	<a href="https://tiptap.dev/" target="_blank">Tiptap 3</a> editor in the browser
	and PHP on the server share one source of truth.
</p>

<div class="alert alert-info py-2 small">
	<i class="bi bi-info-circle"></i>
	The <?= $this->Html->link('WYSIWYG editor', ['action' => 'wysiwyg']) ?> does this
	conversion in the browser. This page does the same trip in PHP, which is what a
	CMS storing Carve needs: it loads and saves the editor model without shelling out
	to JavaScript. Both sides use the schema of the Carve 0.2 Tiptap kit in
	<code>carve-grammars</code>, so either one reads what the other wrote.
</div>

<div class="row">
	<div class="col-md-4">
		<label class="form-label" for="carve-input"><strong>1. Carve source</strong></label>
		<textarea id="carve-input" class="form-control font-monospace" rows="24" style="font-size: 0.85em;"><?= h($defaultCarve) ?></textarea>
	</div>
	<div class="col-md-4">
		<div class="d-flex justify-content-between align-items-center mb-1">
			<label class="form-label mb-0" for="pm-output"><strong>2. ProseMirror document</strong></label>
			<button type="button" class="btn btn-sm btn-outline-secondary" id="btn-copy-pm">
				<i class="bi bi-clipboard"></i> Copy
			</button>
		</div>
		<textarea id="pm-output" class="form-control font-monospace" rows="24" readonly style="font-size: 0.78em;"></textarea>
	</div>
	<div class="col-md-4">
		<label class="form-label" for="carve-back"><strong>3. Back to Carve</strong></label>
		<textarea id="carve-back" class="form-control font-monospace" rows="24" readonly style="font-size: 0.85em;"></textarea>
	</div>
</div>

<div id="alert-container" class="mt-3"></div>

<div class="row mt-3">
	<div class="col-md-6">
		<h5>Round trip</h5>
		<div id="stability" class="small"></div>
	</div>
	<div class="col-md-6">
		<h5>Kept out of the editor</h5>
		<div id="blanked" class="small"></div>
	</div>
</div>

<hr class="my-4">

<h4>Loaded into a real editor, saved by the server</h4>
<p class="text-muted small">
	The editor below is mounted straight from the JSON the <em>server</em> produced; the
	browser never parses the Carve source. Edit it, and the editor's
	<code>getJSON()</code> goes back to PHP, which writes the Carve source shown under it.
</p>
<div id="editor-status" class="small text-muted mb-2">Loading editor...</div>
<div id="tiptap-editor" class="carve border rounded p-3 bg-white" style="min-height: 160px;"></div>
<label class="form-label mt-3" for="carve-saved"><strong>Saved by the server</strong> <span id="saved-status" class="small text-muted"></span></label>
<textarea id="carve-saved" class="form-control font-monospace" rows="12" readonly style="font-size: 0.85em;"></textarea>

<h3 class="mt-4">In PHP</h3>
<pre class="bg-light p-3 border rounded"><code class="language-php">use MarkupCarve\Carve\Carve;
use MarkupCarve\Carve\ProseMirror\ProseMirrorRenderer;
use MarkupCarve\Carve\ProseMirror\ProseMirrorToCarve;

$renderer = new ProseMirrorRenderer();
$json = $renderer-&gt;renderJson(Carve::parse($source));   // hand this to Tiptap
$renderer-&gt;blanked();                                     // denied link and image destinations

$carve = (new ProseMirrorToCarve())-&gt;convert($editorJson);  // editor.getJSON() back to Carve</code></pre>

<?= $this->element('carve/output_styles') ?>

<style>
#tiptap-editor .ProseMirror { outline: none; }
#tiptap-editor h1 { font-size: 1.6em; }
#tiptap-editor h2 { font-size: 1.35em; }
#tiptap-editor pre { background: #f8f9fa; padding: 0.6em 0.8em; border-radius: 6px; }
#tiptap-editor blockquote { border-left: 3px solid #dee2e6; padding-left: 0.8em; color: #6c757d; }
#tiptap-editor .carve-block, #tiptap-editor .carve-inline { background: #f1f3f5; border-radius: 4px; padding: 0 0.3em; }
#tiptap-editor ul[data-type="taskList"] { list-style: none; padding-left: 0.4em; }
#tiptap-editor ul[data-type="taskList"] li { display: flex; gap: 0.5em; align-items: baseline; }
#tiptap-editor ul[data-type="taskList"] li > div > p { margin: 0; }
#tiptap-editor .carve-footnote-ref { color: var(--bs-link-color); cursor: default; }
#tiptap-editor aside.carve-footnote { border-top: 1px solid #dee2e6; margin-top: 1em; padding-top: 0.5em; font-size: 0.9em; display: flex; gap: 0.4em; }
#tiptap-editor aside.carve-footnote[data-key]::before { content: attr(data-key) "."; color: #6c757d; }
#tiptap-editor aside.carve-footnote > p { margin: 0; }
</style>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const carveInput = document.getElementById('carve-input');
	const pmOutput = document.getElementById('pm-output');
	const carveBack = document.getElementById('carve-back');
	const alertContainer = document.getElementById('alert-container');
	const stability = document.getElementById('stability');
	const blanked = document.getElementById('blanked');
	const btnCopyPm = document.getElementById('btn-copy-pm');

	const convertUrl = <?= json_encode($this->Url->build(['action' => 'convertProseMirror'])) ?>;

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	function post(field, value) {
		const formData = new FormData();
		formData.append(field, value);

		return fetch(convertUrl, {
			method: 'POST',
			body: formData,
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		}).then(response => response.json());
	}
	window.carveSaveProseMirror = (json) => post('pm', json);

	let debounceTimer;
	function convert() {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(doConvert, 250);
	}

	function doConvert() {
		post('carve', carveInput.value)
		.then(data => {
			alertContainer.innerHTML = '';
			if (data.error) {
				alertContainer.innerHTML = '<div class="alert alert-danger py-2 mb-0"><strong>Error:</strong> ' + escapeHtml(data.error) + '</div>';

				return;
			}

			pmOutput.value = data.pm || '';
			carveBack.value = data.carve || '';

			stability.innerHTML = (data.stable
				? '<div class="text-success"><i class="bi bi-check-circle"></i> <strong>Meaning</strong> survived: rendered HTML is identical.</div>'
				: '<div class="text-danger"><i class="bi bi-x-circle"></i> <strong>Meaning</strong> changed: rendered HTML differs.</div>')
				+ (data.carveStable
				? '<div class="text-success"><i class="bi bi-check-circle"></i> <strong>Source</strong> survived: identical to <code>Carve::write()</code> of the parsed input.</div>'
				: '<div class="text-warning"><i class="bi bi-exclamation-triangle"></i> <strong>Source</strong> differs from <code>Carve::write()</code> of the parsed input.</div>')
				+ '<div class="text-muted mt-1">to ProseMirror: ' + escapeHtml(String(data.msToPm)) + ' ms'
				+ ' &middot; back to Carve: ' + escapeHtml(String(data.msToCarve)) + ' ms</div>';

			const entries = data.blanked || [];
			blanked.innerHTML = entries.length === 0
				? '<div class="text-success"><i class="bi bi-check-circle"></i> no denied link or image destination</div>'
				: '<div>Denied by the URL policy, so the editor gets <code>null</code> in the link or image attribute; '
					+ 'the value stays in the <code>carve</code> attribute and comes back on save:</div>'
					+ '<ul class="mb-0 ps-3">' + entries.map(url => '<li><code>' + escapeHtml(url) + '</code></li>').join('') + '</ul>';

			if (window.carveMountProseMirror && data.pm) {
				window.carveMountProseMirror(data.pm);
			}
		})
		.catch(err => console.error('ProseMirror bridge error:', err));
	}

	carveInput.addEventListener('input', convert);
	btnCopyPm.addEventListener('click', function() {
		if (!navigator.clipboard) {
			return;
		}
		navigator.clipboard.writeText(pmOutput.value).then(() => {
			const original = btnCopyPm.innerHTML;
			btnCopyPm.innerHTML = '<i class="bi bi-check"></i> Copied!';
			setTimeout(() => { btnCopyPm.innerHTML = original; }, 2000);
		});
	});

	doConvert();
})();
<?php $this->Html->scriptEnd(); ?>

<script type="importmap">
{
	"imports": {
		"@tiptap/core": "https://esm.sh/@tiptap/core@3.32.0",
		"@tiptap/starter-kit": "https://esm.sh/@tiptap/starter-kit@3.32.0",
		"@tiptap/extension-code": "https://esm.sh/@tiptap/extension-code@3.32.0",
		"@tiptap/extension-code-block": "https://esm.sh/@tiptap/extension-code-block@3.32.0",
		"@tiptap/extension-highlight": "https://esm.sh/@tiptap/extension-highlight@3.32.0",
		"@tiptap/extension-subscript": "https://esm.sh/@tiptap/extension-subscript@3.32.0",
		"@tiptap/extension-superscript": "https://esm.sh/@tiptap/extension-superscript@3.32.0",
		"@tiptap/extension-underline": "https://esm.sh/@tiptap/extension-underline@3.32.0",
		"@tiptap/extension-link": "https://esm.sh/@tiptap/extension-link@3.32.0",
		"@tiptap/extension-image": "https://esm.sh/@tiptap/extension-image@3.32.0",
		"@tiptap/extension-table": "https://esm.sh/@tiptap/extension-table@3.32.0",
		"@tiptap/extension-table-row": "https://esm.sh/@tiptap/extension-table-row@3.32.0",
		"@tiptap/extension-table-cell": "https://esm.sh/@tiptap/extension-table-cell@3.32.0",
		"@tiptap/extension-table-header": "https://esm.sh/@tiptap/extension-table-header@3.32.0",
		"@tiptap/extension-task-list": "https://esm.sh/@tiptap/extension-task-list@3.32.0",
		"@tiptap/extension-task-item": "https://esm.sh/@tiptap/extension-task-item@3.32.0",
		"@tiptap/extension-bullet-list": "https://esm.sh/@tiptap/extension-bullet-list@3.32.0",
		"@tiptap/extension-list-item": "https://esm.sh/@tiptap/extension-list-item@3.32.0",
		"@tiptap/extension-hard-break": "https://esm.sh/@tiptap/extension-hard-break@3.32.0",
		"@tiptap/extension-heading": "https://esm.sh/@tiptap/extension-heading@3.32.0",
		"@tiptap/extension-ordered-list": "https://esm.sh/@tiptap/extension-ordered-list@3.32.0",
		"@markup-carve/carve-grammars/tiptap": "https://esm.sh/gh/markup-carve/carve-grammars@3121599/tiptap/index.js?external=@tiptap/core,@tiptap/starter-kit,@tiptap/extension-code,@tiptap/extension-code-block,@tiptap/extension-highlight,@tiptap/extension-subscript,@tiptap/extension-superscript,@tiptap/extension-underline,@tiptap/extension-link,@tiptap/extension-image,@tiptap/extension-table,@tiptap/extension-table-row,@tiptap/extension-table-cell,@tiptap/extension-table-header,@tiptap/extension-task-list,@tiptap/extension-task-item,@tiptap/extension-bullet-list,@tiptap/extension-list-item,@tiptap/extension-ordered-list"
	}
}
</script>

<script type="module">
// The editor is a nice-to-have: it proves the server JSON loads unmodified. A
// CDN hiccup must not take the rest of the page down with it, so the mount is
// guarded and reports its own failure.
const status = document.getElementById('editor-status');
const saved = document.getElementById('carve-saved');
const savedStatus = document.getElementById('saved-status');

function save(editor) {
	window.carveSaveProseMirror(JSON.stringify(editor.getJSON())).then(data => {
		if (data.error) {
			savedStatus.textContent = 'The server could not write the document: ' + data.error;
			savedStatus.className = 'small text-danger';

			return;
		}
		saved.value = data.carve;
		savedStatus.textContent = '(' + data.msToCarve + ' ms)';
		savedStatus.className = 'small text-muted';
	});
}

try {
	const { Editor } = await import('@tiptap/core');
	const { CarveKit } = await import('@markup-carve/carve-grammars/tiptap');

	let saveTimer;
	const editor = new Editor({
		element: document.getElementById('tiptap-editor'),
		extensions: [CarveKit],
		content: { type: 'doc', content: [] },
		editable: true,
		onUpdate: ({ editor }) => {
			clearTimeout(saveTimer);
			saveTimer = setTimeout(() => save(editor), 300);
		},
	});

	window.carveMountProseMirror = function (json) {
		let parsed;
		try {
			parsed = JSON.parse(json);
		} catch (e) {
			status.textContent = 'Server JSON did not parse: ' + (e && e.message ? e.message : e);
			status.className = 'small text-danger mb-2';

			return;
		}

		const expected = (parsed.content || []).length;
		try {
			editor.commands.setContent(parsed, { emitUpdate: false, errorOnInvalidContent: true });
		} catch (e) {
			status.textContent = 'The editor rejected the server document: ' + (e && e.message ? e.message : e);
			status.className = 'small text-danger mb-2';

			return;
		}
		const mounted = editor.state.doc.content.childCount;
		if (expected > 0 && mounted < expected) {
			status.textContent = 'The editor mounted only ' + mounted + ' of ' + expected + ' top-level nodes.';
			status.className = 'small text-danger mb-2';

			return;
		}

		status.innerHTML = '<span class="text-success"><i class="bi bi-check-circle"></i> Mounted from the server document ('
			+ mounted + ' top-level nodes).</span>';
		save(editor);
	};

	const pending = document.getElementById('pm-output').value;
	if (pending) {
		window.carveMountProseMirror(pending);
	} else {
		status.textContent = 'Editor ready, waiting for the server document...';
	}
} catch (e) {
	status.textContent = 'Editor could not be loaded (' + (e && e.message ? e.message : e) + '). The conversion above is unaffected.';
	status.className = 'small text-warning mb-2';
}
</script>
