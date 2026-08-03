<?php
/**
 * @var \App\View\AppView $this
 * @var bool $debugMode
 */

$defaultCarve = <<<'CARVE'
# ProseMirror bridge

A paragraph with *strong*, /emphasis/, `code` and a [link](https://example.org).

- a bullet
- another one

> A blockquote.

``` php
echo 'fenced code';
```

Editorial marks survive as ProseMirror marks: {+inserted+} and {-deleted-}.

::: list-table
- - Cells with block content
  - are a Carve construct
:::
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
	<a href="https://tiptap.dev/" target="_blank">Tiptap</a> editor in the browser
	and PHP rendering on the server can share one source of truth.
</p>

<div class="alert alert-info py-2 small">
	<i class="bi bi-info-circle"></i>
	The <?= $this->Html->link('WYSIWYG editor', ['action' => 'wysiwyg']) ?> does this
	conversion in the browser. This page does the same trip in PHP - which is what a
	CMS storing Carve needs, since it has to load and save the editor model without
	shelling out to JavaScript. Node and mark names come from the map published by
	<code>carve-grammars</code> rather than being restated on each side.
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
		<h5>Fidelity report</h5>
		<div id="fidelity" class="small"></div>
	</div>
</div>

<hr class="my-4">

<h4>Loaded into a real editor</h4>
<p class="text-muted small">
	The document below is mounted straight from the JSON the <em>server</em>
	produced - the browser never parsed the Carve source. The names have to line
	up on both sides: ProseMirror refuses a whole document over a single mark its
	schema does not declare, so a mismatch is not a partial loss, it is an empty
	editor.
</p>
<p class="small">
	<button type="button" class="btn btn-sm btn-outline-warning" id="btn-skew">
		<i class="bi bi-bug"></i> Add an editorial comment
	</button>
	<span class="text-muted ms-2">
		A live check on that: <code>{# ... #}</code> becomes a
		<code>carveCriticComment</code> mark, which only a CarveKit new enough to
		declare it can hold. Pinning an older build is enough to empty this pane
		while the round trip above still reports success - which is why the check
		below compares node counts instead of trusting that nothing threw.
	</span>
</p>
<div id="editor-status" class="small text-muted mb-2">Loading editor...</div>
<div id="tiptap-editor" class="border rounded p-3 bg-white" style="min-height: 160px;"></div>

<h3 class="mt-4">In PHP</h3>
<pre class="bg-light p-3 border rounded"><code class="language-php">use MarkupCarve\Carve\CarveConverter;
use MarkupCarve\Carve\ProseMirror\ProseMirrorRenderer;
use MarkupCarve\Carve\ProseMirror\ProseMirrorToCarve;

$converter = new CarveConverter();
$renderer = new ProseMirrorRenderer();

$document = $renderer-&gt;render($converter-&gt;parse($source));   // array, ready for Tiptap
$renderer-&gt;droppedTypes();                                  // what the editor cannot hold
$renderer-&gt;degradedTypes();                                 // what it holds only loosely

$back = (new ProseMirrorToCarve())-&gt;convert($document);      // and all the way back
$carve = CarveConverter::carve()-&gt;render($back);</code></pre>

<?= $this->element('carve/output_styles') ?>

<style>
#tiptap-editor .ProseMirror { outline: none; }
#tiptap-editor h1 { font-size: 1.6em; }
#tiptap-editor h2 { font-size: 1.35em; }
#tiptap-editor pre { background: #f8f9fa; padding: 0.6em 0.8em; border-radius: 6px; }
#tiptap-editor blockquote { border-left: 3px solid #dee2e6; padding-left: 0.8em; color: #6c757d; }
</style>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const carveInput = document.getElementById('carve-input');
	const pmOutput = document.getElementById('pm-output');
	const carveBack = document.getElementById('carve-back');
	const alertContainer = document.getElementById('alert-container');
	const stability = document.getElementById('stability');
	const fidelity = document.getElementById('fidelity');
	const btnCopyPm = document.getElementById('btn-copy-pm');

	const convertUrl = <?= json_encode($this->Url->build(['action' => 'convertProseMirror'])) ?>;

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	// Both reports come back as a `type => reason` map, so an entry names the
	// construct AND says why it could not be carried exactly.
	function typeList(types, emptyLabel, cssClass) {
		const entries = types ? Object.entries(types) : [];
		if (entries.length === 0) {
			return '<div class="text-success"><i class="bi bi-check-circle"></i> ' + emptyLabel + '</div>';
		}

		return '<ul class="' + cssClass + ' mb-0 ps-3">'
			+ entries.map(([type, reason]) =>
				'<li><code>' + escapeHtml(type) + '</code>'
				+ (reason && reason !== type ? ' <span class="text-muted">- ' + escapeHtml(String(reason)) + '</span>' : '')
				+ '</li>').join('')
			+ '</ul>';
	}

	// A line-level diff is enough here: the losses this bridge produces are
	// re-spellings of a block opener, not reflowed prose.
	function renderFormDiff(before, after) {
		const target = document.getElementById('form-diff');
		const beforeLines = (before || '').split('\n');
		const afterLines = (after || '').split('\n');
		const onlyIn = (a, b) => a.filter(line => line.trim() !== '' && !b.includes(line));

		const removed = onlyIn(beforeLines, afterLines);
		const added = onlyIn(afterLines, beforeLines);

		target.innerHTML = '<div class="row"><div class="col-md-6">'
			+ '<div class="small text-muted">as authored</div>'
			+ '<pre class="border rounded p-2 mb-0 bg-light" style="font-size: 0.8em;">'
			+ removed.map(escapeHtml).join('\n') + '</pre></div><div class="col-md-6">'
			+ '<div class="small text-muted">after the round trip</div>'
			+ '<pre class="border rounded p-2 mb-0 bg-light" style="font-size: 0.8em;">'
			+ added.map(escapeHtml).join('\n') + '</pre></div></div>';
	}

	let debounceTimer;
	function convert() {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(doConvert, 250);
	}

	function doConvert() {
		const formData = new FormData();
		formData.append('carve', carveInput.value);

		fetch(convertUrl, {
			method: 'POST',
			body: formData,
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		})
		.then(response => response.json())
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
				? '<div class="text-success"><i class="bi bi-check-circle"></i> <strong>Authored form</strong> survived: canonical Carve is identical.</div>'
				: '<div class="text-warning"><i class="bi bi-exclamation-triangle"></i> <strong>Authored form</strong> changed: the canonical Carve differs, so the document says the same thing a different way. '
					+ '<button type="button" class="btn btn-link btn-sm p-0 align-baseline" id="btn-show-diff">show what changed</button></div>')
				+ '<div class="text-muted mt-1">to ProseMirror: ' + escapeHtml(String(data.msToPm)) + ' ms'
				+ ' &middot; back to Carve: ' + escapeHtml(String(data.msToCarve)) + ' ms</div>'
				+ '<div id="form-diff" class="mt-2"></div>';

			const btnDiff = document.getElementById('btn-show-diff');
			if (btnDiff) {
				btnDiff.addEventListener('click', () => renderFormDiff(data.canonical, data.carve));
			}

			fidelity.innerHTML = '<div class="mb-1"><strong>Dropped</strong> (no place in the editor model): '
				+ typeList(data.dropped, 'nothing dropped', 'text-danger') + '</div>'
				+ '<div><strong>Degraded</strong> (held, but not exactly): '
				+ typeList(data.degraded, 'nothing degraded', 'text-warning') + '</div>';

			if (window.carveMountProseMirror && data.pm) {
				window.carveMountProseMirror(data.pm);
			}
		})
		.catch(err => console.error('ProseMirror bridge error:', err));
	}

	carveInput.addEventListener('input', convert);
	document.getElementById('btn-skew').addEventListener('click', function() {
		carveInput.value = carveInput.value.replace(/\s*$/, '\n\nAnd {# an editorial comment #} in the prose.\n');
		doConvert();
	});
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
		"@tiptap/core": "https://esm.sh/@tiptap/core@2",
		"@tiptap/starter-kit": "https://esm.sh/@tiptap/starter-kit@2",
		"@tiptap/extension-code-block": "https://esm.sh/@tiptap/extension-code-block@2",
		"@tiptap/extension-highlight": "https://esm.sh/@tiptap/extension-highlight@2",
		"@tiptap/extension-subscript": "https://esm.sh/@tiptap/extension-subscript@2",
		"@tiptap/extension-superscript": "https://esm.sh/@tiptap/extension-superscript@2",
		"@tiptap/extension-underline": "https://esm.sh/@tiptap/extension-underline@2",
		"@tiptap/extension-link": "https://esm.sh/@tiptap/extension-link@2",
		"@tiptap/extension-image": "https://esm.sh/@tiptap/extension-image@2",
		"@tiptap/extension-table": "https://esm.sh/@tiptap/extension-table@2",
		"@tiptap/extension-table-row": "https://esm.sh/@tiptap/extension-table-row@2",
		"@tiptap/extension-table-cell": "https://esm.sh/@tiptap/extension-table-cell@2",
		"@tiptap/extension-table-header": "https://esm.sh/@tiptap/extension-table-header@2",
		"@tiptap/extension-task-list": "https://esm.sh/@tiptap/extension-task-list@2",
		"@tiptap/extension-task-item": "https://esm.sh/@tiptap/extension-task-item@2",
		"@tiptap/extension-bullet-list": "https://esm.sh/@tiptap/extension-bullet-list@2",
		"@tiptap/extension-list-item": "https://esm.sh/@tiptap/extension-list-item@2",
		"@tiptap/extension-hard-break": "https://esm.sh/@tiptap/extension-hard-break@2",
		"carve-grammars/carve-kit.js": "https://esm.sh/gh/markup-carve/carve-grammars@d11ff98/tiptap/carve-kit.js?external=@tiptap/core,@tiptap/starter-kit,@tiptap/extension-code-block,@tiptap/extension-highlight,@tiptap/extension-subscript,@tiptap/extension-superscript,@tiptap/extension-underline,@tiptap/extension-link,@tiptap/extension-image,@tiptap/extension-table,@tiptap/extension-table-row,@tiptap/extension-table-cell,@tiptap/extension-table-header,@tiptap/extension-task-list,@tiptap/extension-task-item,@tiptap/extension-bullet-list,@tiptap/extension-list-item,@tiptap/extension-hard-break"
	}
}
</script>

<script type="module">
// The editor is a nice-to-have: it proves the server JSON loads unmodified. A
// CDN hiccup must not take the rest of the page down with it, so the mount is
// guarded and reports its own failure.
const status = document.getElementById('editor-status');

try {
	const { Editor } = await import('@tiptap/core');
	const { CarveKit } = await import('carve-grammars/carve-kit.js');

	const editor = new Editor({
		element: document.getElementById('tiptap-editor'),
		extensions: [CarveKit],
		content: { type: 'doc', content: [] },
		editable: true,
	});

	// Tiptap does not throw on a document its schema cannot hold - it warns to
	// the console and falls back to an empty document, which is ONE empty
	// paragraph, not zero nodes. So neither "no exception" nor "childCount > 0"
	// proves anything; compare the node count against what was handed in.
	window.carveMountProseMirror = function (json) {
		let parsed;
		try {
			parsed = JSON.parse(json);
		} catch (e) {
			status.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle"></i> Server JSON did not parse: '
				+ (e && e.message ? e.message : e) + '</span>';

			return;
		}

		const expected = (parsed.content || []).length;
		editor.commands.setContent(parsed, false);
		const mounted = editor.state.doc.content.childCount;

		if (expected > 0 && mounted < expected) {
			status.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle"></i> '
				+ 'The editor rejected the document (' + expected + ' top-level nodes in, ' + mounted + ' mounted). '
				+ 'ProseMirror discards the whole document over one undeclared node or mark - see the console warning '
				+ 'for which name is missing from the browser schema.</span>';

			return;
		}

		status.innerHTML = '<span class="text-success"><i class="bi bi-check-circle"></i> Mounted from the server document ('
			+ mounted + ' top-level nodes).</span>';
	};

	const pending = document.getElementById('pm-output').value;
	if (pending) {
		window.carveMountProseMirror(pending);
	} else {
		status.textContent = 'Editor ready, waiting for the server document...';
	}
} catch (e) {
	status.innerHTML = '<span class="text-warning"><i class="bi bi-exclamation-triangle"></i> Editor could not be loaded ('
		+ (e && e.message ? e.message : e) + '). The conversion above is unaffected.</span>';
}
</script>
