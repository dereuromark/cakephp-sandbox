<?php
/**
 * @var \App\View\AppView $this
 * @var string $carve
 */
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Carve &rarr; Pandoc</h2>
<p>
	<?= $this->Html->link('pandoc-carve', 'https://github.com/markup-carve/pandoc-carve', ['target' => '_blank']) ?>
	is a bidirectional Carve &harr; Pandoc bridge. Converting Carve to Pandoc's JSON AST
	unlocks every pandoc writer at once - LaTeX, Typst, DOCX, PDF, RST, JATS, EPUB and
	dozens more - without Carve needing a writer for any of them.
</p>

<pre class="small">.crv ──parse──▶ Carve AST ──carveToPandoc()──▶ Pandoc JSON ──pandoc -f json -t X──▶ .tex / .typ / .docx / …</pre>

<div class="alert alert-info">
	<strong>No pandoc binary is involved on this page.</strong>
	Emitting the JSON AST is pure computation; only converting that JSON <em>onwards</em> to a
	real format needs pandoc installed. So this demo runs entirely in your browser, with
	<code>pandoc-carve</code> loaded as an ES module.
</div>

<p class="text-muted small">
	Note what pandoc does <em>not</em> reach: it ships no writer for Slack, Discord, WhatsApp,
	Telegram or any chat platform - the closest is <code>jira</code>. That gap is what the
	<?= $this->Html->link('Chat Export', ['action' => 'chatExport']) ?> demo covers instead.
</p>

<div class="row">
	<div class="col-lg-6">
		<label class="form-label" for="carve-source">Carve markup</label>
		<textarea id="carve-source" class="form-control font-monospace" rows="16"><?= h($carve) ?></textarea>
	</div>
	<div class="col-lg-6">
		<label class="form-label" for="pandoc-output">Pandoc JSON AST</label>
		<textarea id="pandoc-output" class="form-control font-monospace" rows="16" readonly></textarea>
	</div>
</div>

<p class="mt-2">
	<span id="pandoc-status" class="text-muted small">Loading pandoc-carve&hellip;</span>
</p>

<div id="pandoc-warnings" class="alert alert-warning d-none">
	<strong>Degradation warnings</strong>
	<pre class="mb-0 mt-2 small" id="pandoc-warnings-body"></pre>
</div>

<p class="text-muted small">
	Like the chat exporters, the bridge reports what it could not carry faithfully rather
	than dropping it silently - Pandoc's AST has no equivalent for every Carve construct either.
</p>

<h3>Converting onwards</h3>
<p>Once you have the JSON, any pandoc writer takes it:</p>
<pre><code>pandoc-carve doc.crv | pandoc -f json -t latex -o doc.tex
pandoc-carve doc.crv | pandoc -f json -t docx  -o doc.docx
pandoc-carve doc.crv | pandoc -f json -t typst -o doc.typ</code></pre>

<p class="text-muted small">
	The bridge also runs in reverse: <code>pandocToCarve()</code> turns anything pandoc reads
	(DOCX, LaTeX, RST, Org, MediaWiki, HTML, Markdown, &hellip;) back into Carve source.
</p>

<script type="importmap">
{
	"imports": {
		"@markup-carve/carve": "https://esm.sh/gh/markup-carve/carve-js@672a496/src/index.ts",
		"pandoc-carve": "https://esm.sh/gh/markup-carve/pandoc-carve@f2e30d5/src/index.ts?external=@markup-carve/carve"
	}
}
</script>

<script type="module">
const source = document.getElementById('carve-source');
const output = document.getElementById('pandoc-output');
const status = document.getElementById('pandoc-status');
const warnings = document.getElementById('pandoc-warnings');
const warningsBody = document.getElementById('pandoc-warnings-body');

let carveToPandoc;

// Pinned to a commit so the demo cannot drift when the bridge moves on.
try {
	({ carveToPandoc } = await import('pandoc-carve'));
	status.textContent = 'pandoc-carve loaded - converting as you type.';
} catch (e) {
	status.textContent = 'Could not load pandoc-carve: ' + e.message;
	status.className = 'text-danger small';
}

function convert() {
	if (!carveToPandoc) {
		return;
	}

	try {
		const result = carveToPandoc(source.value);
		output.value = JSON.stringify(result.doc, null, 2);

		if (result.warnings && result.warnings.length) {
			warningsBody.textContent = result.warnings.join('\n');
			warnings.classList.remove('d-none');
		} else {
			warnings.classList.add('d-none');
		}
	} catch (e) {
		output.value = '';
		warningsBody.textContent = e.message;
		warnings.classList.remove('d-none');
	}
}

let timer;
source.addEventListener('input', () => {
	clearTimeout(timer);
	timer = setTimeout(convert, 200);
});

convert();
</script>

</div>
