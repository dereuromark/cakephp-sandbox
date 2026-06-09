<?php
/**
 * @var \App\View\AppView $this
 */

$this->append('script');
echo $this->Html->script('Sandbox.carve-js.min.js');
$this->end();

$defaultSource = <<<'SOURCE'
# Migrating to Carve

This paragraph has **Markdown bold** and _Djot emphasis_ that
collide with Carve's delimiters. Also ~~strikethrough~~ the old way.

+ A plus bullet (Djot continuation marker, not a Carve bullet)
+ Another one

This part is **_bold and emphasized_** at once - an overlapping
collision the autofix leaves for manual review.
SOURCE;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Migration Fix <small class="text-muted">(<code>carve fix</code>)</small></h2>
<p>
	Autocorrect Djot/Markdown <strong>delimiter collisions</strong> to their Carve equivalents -
	<code>**bold**</code> &rarr; <code>*bold*</code>, <code>_em_</code> &rarr; <code>/em/</code>,
	<code>~~strike~~</code> &rarr; <code>~strike~</code>, <code>+</code> bullets &rarr; <code>-</code>.
	This is a minimal-diff <em>linter/autocorrect</em>, not a full converter: it only rewrites the
	exact spans that would mis-render, and reports anything it cannot safely fix.
</p>
<div class="alert alert-info py-2 small">
	<i class="bi bi-info-circle"></i>
	Runs <strong>fully client-side</strong> in your browser via the bundled
	<?= $this->Html->link('carve-js', 'https://github.com/markup-carve/carve-js', ['target' => '_blank']) ?>
	library (<code>applyMigrationFixes</code>). This is the same logic the
	<?= $this->Html->link('carve fix CLI (PR #91)', 'https://github.com/markup-carve/carve-js/pull/91', ['target' => '_blank']) ?>
	wraps - no server round-trip.
</div>

<div id="carvejs-missing" class="alert alert-danger py-2" style="display: none;">
	<strong>carve-js failed to load.</strong> The bundled library could not be found - the demo cannot run.
</div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label" for="mf-input"><strong>Djot / Markdown Input</strong></label>
		<textarea id="mf-input" class="form-control font-monospace" rows="16" placeholder="Paste Djot/Markdown with delimiter collisions..."><?= h($defaultSource) ?></textarea>
	</div>
	<div class="col-md-6">
		<div class="d-flex justify-content-between align-items-center mb-1">
			<label class="form-label mb-0" for="mf-output"><strong>Fixed Carve Output</strong></label>
			<div>
				<button type="button" class="btn btn-sm btn-outline-secondary" id="mf-copy" title="Copy fixed output">
					<i class="bi bi-clipboard"></i> Copy
				</button>
				<?= $this->Html->link('<i class="bi bi-play-fill"></i> Try in Playground', ['action' => 'index'], ['escapeTitle' => false, 'class' => 'btn btn-sm btn-outline-primary', 'id' => 'mf-try', 'target' => '_blank']) ?>
			</div>
		</div>
		<textarea id="mf-output" class="form-control font-monospace" rows="16" readonly placeholder="Fixed Carve output will appear here..."></textarea>
	</div>
</div>

<div class="mt-3" id="mf-gate"></div>

<div class="row mt-3">
	<div class="col-md-7">
		<h4 class="h6">Applied fixes <span class="badge bg-success" id="mf-applied-count">0</span></h4>
		<div class="table-responsive">
			<table class="table table-sm table-striped small align-middle">
				<thead>
					<tr>
						<th style="width: 5rem;">Line:Col</th>
						<th>Rule</th>
						<th>Before</th>
						<th>After</th>
					</tr>
				</thead>
				<tbody id="mf-applied-body">
					<tr><td colspan="4" class="text-muted">No fixes applied.</td></tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-5">
		<h4 class="h6">Manual review <span class="badge bg-warning text-dark" id="mf-skipped-count">0</span></h4>
		<p class="text-muted small">
			Overlapping collisions (e.g. <code>**_x_**</code> - strong <em>and</em> emphasis) are not
			guessed at. Rewriting both spans in one pass would corrupt offsets, so they are left for you.
		</p>
		<ul class="list-group list-group-flush small" id="mf-skipped-list">
			<li class="list-group-item text-muted px-0">Nothing needs manual review.</li>
		</ul>
	</div>
</div>

<h3 class="mt-4 h5">How <code>carve fix</code> uses this</h3>
<table class="table table-sm small">
	<thead>
		<tr><th>Command</th><th>Behavior</th></tr>
	</thead>
	<tbody>
		<tr><td><code>carve fix &lt; in.crv</code></td><td>stdin &rarr; stdout - print the fixed text (the <strong>Output</strong> pane above)</td></tr>
		<tr><td><code>carve fix --write doc.crv</code></td><td>rewrite the file in place with the applied fixes</td></tr>
		<tr><td><code>carve fix --check doc.crv</code></td><td>CI gate - exit non-zero if anything would change or needs manual review (the <strong>gate badge</strong> above)</td></tr>
	</tbody>
</table>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const input = document.getElementById('mf-input');
	const output = document.getElementById('mf-output');
	const gate = document.getElementById('mf-gate');
	const appliedBody = document.getElementById('mf-applied-body');
	const appliedCount = document.getElementById('mf-applied-count');
	const skippedList = document.getElementById('mf-skipped-list');
	const skippedCount = document.getElementById('mf-skipped-count');
	const btnCopy = document.getElementById('mf-copy');

	if (typeof window.CarveJS === 'undefined' || typeof window.CarveJS.applyMigrationFixes !== 'function') {
		document.getElementById('carvejs-missing').style.display = '';
		return;
	}

	function escapeHtml(str) {
		const div = document.createElement('div');
		div.textContent = str;
		return div.innerHTML;
	}

	function snippet(source, warning) {
		// Prefer the exact source span; fall back to the suggestion if offsets are missing.
		if (typeof warning.start === 'number' && typeof warning.end === 'number') {
			return source.slice(warning.start, warning.end);
		}
		return warning.suggestion;
	}

	let debounceTimer;

	function run() {
		const source = input.value;
		const result = window.CarveJS.applyMigrationFixes(source);

		output.value = result.output;

		// Applied fixes table.
		appliedCount.textContent = String(result.applied.length);
		if (result.applied.length === 0) {
			appliedBody.innerHTML = '<tr><td colspan="4" class="text-muted">No fixes applied.</td></tr>';
		} else {
			appliedBody.innerHTML = result.applied.map(function(w) {
				return '<tr>'
					+ '<td class="text-nowrap">' + w.line + ':' + w.column + '</td>'
					+ '<td><code>' + escapeHtml(w.rule) + '</code></td>'
					+ '<td><code class="text-danger">' + escapeHtml(snippet(source, w)) + '</code></td>'
					+ '<td><code class="text-success">' + escapeHtml(w.suggestion) + '</code></td>'
					+ '</tr>';
			}).join('');
		}

		// Skipped (manual review) list.
		skippedCount.textContent = String(result.skipped.length);
		if (result.skipped.length === 0) {
			skippedList.innerHTML = '<li class="list-group-item text-muted px-0">Nothing needs manual review.</li>';
		} else {
			skippedList.innerHTML = result.skipped.map(function(w) {
				return '<li class="list-group-item px-0">'
					+ '<span class="text-nowrap fw-bold">' + w.line + ':' + w.column + '</span> '
					+ '<code>' + escapeHtml(w.rule) + '</code><br>'
					+ '<span class="text-muted">' + escapeHtml(w.message) + '</span>'
					+ '</li>';
			}).join('');
		}

		// --check gate badge: exit non-zero when anything would change or needs manual review.
		const changed = result.applied.length;
		const manual = result.skipped.length;
		if (changed === 0 && manual === 0) {
			gate.innerHTML = '<div class="alert alert-success py-2 mb-0">'
				+ '<i class="bi bi-check-circle"></i> <strong><code>carve fix --check</code>: clean</strong> (exit 0) - no collisions.'
				+ '</div>';
		} else {
			const parts = [];
			if (changed > 0) { parts.push(changed + ' would change'); }
			if (manual > 0) { parts.push(manual + ' need manual review'); }
			gate.innerHTML = '<div class="alert alert-danger py-2 mb-0">'
				+ '<i class="bi bi-x-circle"></i> <strong><code>carve fix --check</code>: ' + escapeHtml(parts.join(' · ')) + '</strong> (exit 1).'
				+ '</div>';
		}
	}

	input.addEventListener('input', function() {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(run, 150);
	});

	btnCopy.addEventListener('click', function() {
		navigator.clipboard.writeText(output.value).then(function() {
			const original = btnCopy.innerHTML;
			btnCopy.innerHTML = '<i class="bi bi-check"></i> Copied';
			setTimeout(function() { btnCopy.innerHTML = original; }, 1200);
		});
	});

	run();
})();
<?php $this->Html->scriptEnd(); ?>
