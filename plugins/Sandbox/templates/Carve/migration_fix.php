<?php
/**
 * @var \App\View\AppView $this
 */

$this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/github.min.css', ['block' => true]);
$this->Html->css('Sandbox.highlighting/hljs-carve.css', ['block' => true, 'timestamp' => 'force']);
$this->Html->css('Sandbox.highlighting/carve-code.css', ['block' => true, 'timestamp' => 'force']);

$this->append('script');
$bundle = WWW_ROOT . 'js' . DS . 'carve-js.min.js';
$bundleVersion = is_file($bundle) ? (string)filemtime($bundle) : '1';
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-carve.js');
echo $this->Html->script('Sandbox.hljs-carve-delimited.js');
echo $this->Html->script('carve-js.min.js?v=' . $bundleVersion);
$this->end();

$defaultSource = <<<'SOURCE'
# Migrating to Carve

This paragraph has **Markdown bold** and _Djot emphasis_ that
collide with Carve's delimiters. Also ~~strikethrough~~ the old way.

+ A plus bullet (Djot continuation marker, not a Carve bullet)
+ Another one

Nested collisions now compose in one pass: **_bold and emphasized_**
and ~~_struck and emphasized_~~ are fixed automatically.

Only a crossing overlap like **_x**_ - where neither span contains
the other - stays ambiguous and is left for manual review.
SOURCE;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<style>
#mf-output {
	display: block;
	min-height: 16rem;
	max-height: 26rem;
	overflow: auto;
	margin: 0;
}
.mf-diff {
	max-height: 22rem;
	overflow: auto;
	white-space: pre-wrap;
	word-break: break-word;
}
.mf-dline {
	padding: 0 .25rem;
	border-left: 3px solid transparent;
}
.mf-dline.mf-changed {
	background: #f6fff6;
	border-left-color: #198754;
}
.mf-dline.mf-skip-line {
	background: #fff8e6;
	border-left-color: #ffc107;
}
.mf-diff del {
	background: #ffe3e3;
	color: #b02a37;
	text-decoration: line-through;
}
.mf-diff ins {
	background: #d1f0d8;
	color: #0f5132;
	text-decoration: none;
}
.mf-jumpable {
	cursor: pointer;
}
.mf-flash {
	animation: mf-flash-anim 1.2s ease-out;
}
@keyframes mf-flash-anim {
	0% { background: #fff3cd; }
	100% { background: transparent; }
}
.mf-dline.mf-flash {
	animation: mf-flash-line 1.2s ease-out;
}
@keyframes mf-flash-line {
	0% { background: #ffe69c; }
	100% { background: inherit; }
}
</style>

<h2>Migration Fix <small class="text-muted">(<code>carve fix</code>)</small></h2>
<p>
	Autocorrect Djot/Markdown <strong>delimiter collisions</strong> to their Carve equivalents -
	<code>**bold**</code> &rarr; <code>*bold*</code>, <code>_em_</code> &rarr; <code>/em/</code>,
	<code>~~strike~~</code> &rarr; <code>{~strike~}</code>, <code>+</code> bullets &rarr; <code>-</code>.
	This is a minimal-diff <em>linter/autocorrect</em>, not a full converter: it only rewrites the
	exact spans that would mis-render. Strictly nested collisions like <code>**_x_**</code> &rarr;
	<code>*/x/*</code> compose; a fix that would not hold, such as a <em>crossing</em> overlap, is
	left alone, and whatever <code>carve lint</code> still reports on the output is listed for manual review.
</p>
<div class="alert alert-info py-2 small">
	<i class="bi bi-info-circle"></i>
	Runs <strong>fully client-side</strong> in your browser via the bundled
	<?= $this->Html->link('carve-js', 'https://github.com/markup-carve/carve-js', ['target' => '_blank']) ?>
	library (<code>fix</code>, <code>lint</code> and <code>fixEdits</code>). This is the same logic the
	<code>carve fix</code> CLI wraps - no server round-trip.
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
		<pre class="form-control font-monospace"><code id="mf-output" class="language-carve hljs"></code></pre>
	</div>
</div>

<div class="mt-3">
	<label class="form-label mb-1"><strong>Changes</strong> <span class="text-muted small">(old delimiter struck, new in green - click an entry below to jump)</span></label>
	<pre id="mf-diff" class="form-control font-monospace mf-diff"></pre>
</div>

<div class="row mt-3">
	<div class="col-md-7">
		<h4 class="h6">Applied fixes <span class="badge bg-success" id="mf-applied-count">0</span></h4>
		<div class="table-responsive">
			<table class="table table-sm table-striped small align-middle">
				<thead>
					<tr>
						<th style="width: 5rem;">Line:Col</th>
						<th>Rule</th>
						<th style="width: 4rem;">Fixes</th>
						<th>Why</th>
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
			Lint findings on the <strong>fixed output</strong>. A <em>crossing</em> overlap such as
			<code>**_x**_</code> gets only the fix that holds and may need a look by hand.
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
		<tr><td><code>carve lint doc.crv</code></td><td>report what is still left (the <strong>Manual review</strong> list above)</td></tr>
	</tbody>
</table>
<p class="text-muted small">The <code>carve fix --check</code> CI gate of Carve 0.1 is gone in 0.2.</p>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const input = document.getElementById('mf-input');
	const output = document.getElementById('mf-output');
	const diff = document.getElementById('mf-diff');
	const appliedBody = document.getElementById('mf-applied-body');
	const appliedCount = document.getElementById('mf-applied-count');
	const skippedList = document.getElementById('mf-skipped-list');
	const skippedCount = document.getElementById('mf-skipped-count');
	const btnCopy = document.getElementById('mf-copy');
	const tryLink = document.getElementById('mf-try');
	const playgroundUrl = '<?= $this->Url->build(['action' => 'index']) ?>';
	let lastOutput = '';

	function compress(str) {
		return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, (m, p1) => String.fromCharCode('0x' + p1)));
	}

	const engine = window.CarveJS;
	if (typeof engine === 'undefined' || typeof engine.fix !== 'function') {
		document.getElementById('carvejs-missing').style.display = '';
		return;
	}
	// `fix` turns every fixable rule on; lint needs them switched on explicitly to list them.
	const fixableRules = new Set(engine.fixableRules);
	const lintOptions = { rules: Object.fromEntries(engine.fixableRules.map(rule => [rule, 'on'])) };

	function escapeHtml(str) {
		const div = document.createElement('div');
		div.textContent = str;
		return div.innerHTML;
	}

	// Diagnostic ranges count UTF-8 bytes.
	function position(source, diagnostic) {
		return diagnostic.range ? engine.positionOf(source, diagnostic.range.startOffset) : { line: 1, column: 1 };
	}

	// Syntax-highlight the fixed Carve output with the hljs-carve grammar.
	// Degrade to plain text if highlight.js or the carve grammar is unavailable
	// (e.g. the grammar file failed to load) - never let it break the demo.
	function renderOutput(text) {
		if (window.hljs && typeof hljs.highlight === 'function' && hljs.getLanguage && hljs.getLanguage('carve')) {
			try {
				output.innerHTML = hljs.highlight(text, { language: 'carve' }).value;
				return;
			} catch (e) {
				// fall through to plain text
			}
		}
		output.textContent = text;
	}

	// In-place delimiter swaps keep source and output line-aligned, so a
	// per-line prefix/suffix diff shows exactly which delimiters changed.
	function renderDiff(source, out) {
		const a = source.split('\n');
		const b = out.split('\n');
		const n = Math.max(a.length, b.length);
		let html = '';
		for (let i = 0; i < n; i++) {
			const s = a[i] !== undefined ? a[i] : '';
			const o = b[i] !== undefined ? b[i] : '';
			const ln = i + 1;
			if (s === o) {
				html += '<div class="mf-dline" data-line="' + ln + '">' + (escapeHtml(o) || '&nbsp;') + '</div>';
				continue;
			}
			let p = 0;
			while (p < s.length && p < o.length && s[p] === o[p]) { p++; }
			let q = 0;
			while (q < s.length - p && q < o.length - p && s[s.length - 1 - q] === o[o.length - 1 - q]) { q++; }
			const pre = escapeHtml(s.slice(0, p));
			const delMid = escapeHtml(s.slice(p, s.length - q));
			const insMid = escapeHtml(o.slice(p, o.length - q));
			const suf = escapeHtml(s.slice(s.length - q));
			html += '<div class="mf-dline mf-changed" data-line="' + ln + '">'
				+ pre
				+ (delMid ? '<del>' + delMid + '</del>' : '')
				+ (insMid ? '<ins>' + insMid + '</ins>' : '')
				+ suf
				+ '</div>';
		}
		diff.innerHTML = html;
	}

	function flashLine(line) {
		const el = diff.querySelector('.mf-dline[data-line="' + line + '"]');
		if (!el) { return; }
		el.classList.remove('mf-flash');
		void el.offsetWidth; // restart the animation
		el.classList.add('mf-flash');
		el.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
	}

	let debounceTimer;

	function run() {
		const source = input.value;
		const result = engine.fix(source);

		lastOutput = result.output;
		renderOutput(result.output);
		renderDiff(source, result.output);
		// Carry the fixed output into the playground (?d= matches index decode).
		tryLink.href = playgroundUrl + '?d=' + encodeURIComponent(compress(result.output || ''));

		// Applied fixes by rule; a row jumps to the first finding of that rule in the source.
		const findings = engine.lint(source, lintOptions).filter(d => fixableRules.has(d.code));
		const applied = Array.from(result.applied, ([rule, count]) => {
			const first = findings.find(d => d.code === rule);
			return { rule, count, first, at: first ? position(source, first) : null };
		});
		appliedCount.textContent = String(applied.reduce((sum, row) => sum + row.count, 0));
		if (applied.length === 0) {
			appliedBody.innerHTML = '<tr><td colspan="4" class="text-muted">No fixes applied.</td></tr>';
		} else {
			appliedBody.innerHTML = applied.map(function(row) {
				const at = row.at ? row.at.line + ':' + row.at.column : '';
				return '<tr class="mf-jumpable" data-line="' + (row.at ? row.at.line : '') + '" title="Jump to the first change">'
					+ '<td class="text-nowrap">' + at + '</td>'
					+ '<td><code>' + escapeHtml(row.rule) + '</code></td>'
					+ '<td>' + row.count + '</td>'
					+ '<td class="text-muted">' + escapeHtml(row.first ? row.first.message : '') + '</td>'
					+ '</tr>';
			}).join('');
		}

		// What lint still reports on the output (jumps; tints the output line amber).
		const remaining = engine.lint(result.output, lintOptions);
		skippedCount.textContent = String(remaining.length);
		if (remaining.length === 0) {
			skippedList.innerHTML = '<li class="list-group-item text-muted px-0">Nothing needs manual review.</li>';
		} else {
			skippedList.innerHTML = remaining.map(function(d) {
				const at = position(result.output, d);
				return '<li class="list-group-item px-0 mf-jumpable" data-line="' + at.line + '" title="Jump to this line">'
					+ '<span class="text-nowrap fw-bold">' + at.line + ':' + at.column + '</span> '
					+ '<code>' + escapeHtml(d.code) + '</code><br>'
					+ '<span class="text-muted">' + escapeHtml(d.message) + '</span>'
					+ '</li>';
			}).join('');
			remaining.forEach(function(d) {
				const el = diff.querySelector('.mf-dline[data-line="' + position(result.output, d).line + '"]');
				if (el) { el.classList.add('mf-skip-line'); }
			});
		}
	}

	input.addEventListener('input', function() {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(run, 150);
	});

	// Delegated click: jump from an applied row or a skipped entry to its diff line.
	function jumpHandler(e) {
		const row = e.target.closest('.mf-jumpable');
		if (row && row.dataset.line) { flashLine(parseInt(row.dataset.line, 10)); }
	}
	appliedBody.addEventListener('click', jumpHandler);
	skippedList.addEventListener('click', jumpHandler);

	btnCopy.addEventListener('click', function() {
		navigator.clipboard.writeText(lastOutput).then(function() {
			const original = btnCopy.innerHTML;
			btnCopy.innerHTML = '<i class="bi bi-check"></i> Copied';
			setTimeout(function() { btnCopy.innerHTML = original; }, 1200);
		});
	});

	run();
})();
<?php $this->Html->scriptEnd(); ?>
