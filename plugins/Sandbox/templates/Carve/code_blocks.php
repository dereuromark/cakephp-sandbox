<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array<string, string>> $examples
 */

$this->append('script');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-carve.js');
$this->end();
?>

<div class="row">
<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Code Blocks</h2>
<p>
	Carve renders a fenced block as <code>&lt;pre&gt;&lt;code class="language-X"&gt;</code> and copies any
	attributes from the preceding <code>{...}</code> line onto the <code>&lt;pre&gt;</code>. A syntax
	highlighter (here <a href="https://highlightjs.org" target="_blank">highlight.js</a>) plus a little
	page JS turn those attributes into line numbers, highlighted lines, diffs, focus, a title bar and a
	copy button - no Carve core change needed.
</p>

<div class="alert alert-info">
	<strong>Attribute cheatsheet</strong> (all on the line before the fence):
	<ul class="mb-0">
		<li><code>{.line-numbers}</code> - gutter with line numbers; <code>data-line-start="N"</code> offsets the first number.</li>
		<li><code>{data-highlight="2,4-6"}</code> - highlight those lines.</li>
		<li><code>{data-add="3" data-remove="2"}</code> - diff markers (green / red).</li>
		<li><code>{data-focus="3-4"}</code> - dim everything else (hover to restore).</li>
		<li><code>``` lang "Header"</code> - filename header right on the fence (spec-native, carve#201); <code>{title="path/to/file.php"}</code> does the same and wins if both are set.</li>
		<li><code>``` lang "Header" [Label]</code> - the bracketed <code>[Label]</code> is inert in core (the Code Groups extension uses it for tab names).</li>
	</ul>
</div>

<?php foreach ($examples as $key => $example) { ?>
<div class="card mb-4" id="cb-<?= h($key) ?>">
	<div class="card-header">
		<h4 class="mb-0"><?= h($example['title']) ?></h4>
	</div>
	<div class="card-body">
		<p class="lead"><?= preg_replace('/`([^`]+)`/', '<code>$1</code>', h($example['description'])) ?></p>
		<div class="row">
			<div class="col-lg-6">
				<h6 class="text-muted">Carve source</h6>
				<pre class="border rounded p-2 bg-light mb-3"><code class="language-carve"><?= h($example['carve']) ?></code></pre>
			</div>
			<div class="col-lg-6">
				<h6 class="text-muted">Rendered</h6>
				<div class="cb-output"><?= $example['html'] ?></div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

</div>
</div>

<style>
.cb-output pre {
	margin: 0;
	background: #f6f8fa;
	border: 1px solid #d0d7de;
	border-radius: 6px;
	overflow: hidden;
}
.cb-wrap {
	border: 1px solid #d0d7de;
	border-radius: 6px;
	overflow: hidden;
	margin-bottom: 1rem;
	background: #f6f8fa;
}
.cb-titlebar {
	display: flex;
	align-items: center;
	gap: 0.5rem;
	padding: 0.35rem 0.6rem;
	background: #eaeef2;
	border-bottom: 1px solid #d0d7de;
	font-size: 0.85em;
}
.cb-title {
	font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
	color: #57606a;
}
.cb-lang {
	margin-left: auto;
	text-transform: uppercase;
	font-size: 0.75em;
	letter-spacing: 0.04em;
	color: #fff;
	background: #6e7781;
	padding: 0.05em 0.45em;
	border-radius: 3px;
}
.cb-copy {
	border: 1px solid #d0d7de;
	background: #fff;
	border-radius: 4px;
	font-size: 0.75em;
	padding: 0.1em 0.5em;
	cursor: pointer;
	color: #57606a;
}
.cb-copy:hover { border-color: #0969da; color: #0969da; }
.cb-copy.copied { color: #1a7f37; border-color: #1a7f37; }
.cb-wrap pre.cb-pre {
	margin: 0;
	border: 0;
	background: transparent;
	border-radius: 0;
	overflow-x: auto;
}
.cb-pre code { display: block; }
.cb-line {
	display: flex;
	width: max-content;
	min-width: 100%;
	padding: 0 0.6rem;
}
.cb-gutter {
	flex: 0 0 auto;
	min-width: 2.4em;
	padding-right: 0.9rem;
	text-align: right;
	color: #8c959f;
	user-select: none;
	-webkit-user-select: none;
}
.cb-line .cb-code { flex: 1 1 auto; white-space: pre; }
.cb-line.hl { background: #fff8c5; }
.cb-line.add { background: #e6ffec; }
.cb-line.add .cb-gutter::before { content: "+"; color: #1a7f37; }
.cb-line.del { background: #ffebe9; }
.cb-line.del .cb-gutter::before { content: "-"; color: #cf222e; }
.cb-line.add .cb-gutter,
.cb-line.del .cb-gutter { min-width: 1.4em; }
/* focus: dim non-focused lines until the block is hovered */
.cb-pre.has-focus .cb-line:not(.focus) { opacity: 0.35; transition: opacity 0.15s; }
.cb-pre.has-focus:hover .cb-line { opacity: 1; }
</style>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function () {
	// Parse "2,4-6" into a Set of line numbers.
	function parseRanges(spec) {
		const set = new Set();
		if (!spec) return set;
		for (const part of spec.split(',')) {
			const m = part.trim().match(/^(\d+)(?:-(\d+))?$/);
			if (!m) continue;
			const a = parseInt(m[1], 10);
			const b = m[2] ? parseInt(m[2], 10) : a;
			for (let i = a; i <= b; i++) set.add(i);
		}
		return set;
	}

	function enhance(pre) {
		const code = pre.querySelector('code');
		if (!code) return;

		const rawText = code.textContent.replace(/\n$/, '');
		const langMatch = (code.className || '').match(/language-([\w-]+)/);
		const lang = langMatch ? langMatch[1] : '';

		if (window.hljs && lang && lang !== 'plaintext') {
			try { window.hljs.highlightElement(code); } catch (e) { /* leave plain */ }
		}

		const showNumbers = pre.classList.contains('line-numbers');
		const start = parseInt(pre.getAttribute('data-line-start') || '1', 10) || 1;
		const hl = parseRanges(pre.getAttribute('data-highlight'));
		const add = parseRanges(pre.getAttribute('data-add'));
		const del = parseRanges(pre.getAttribute('data-remove'));
		const focus = parseRanges(pre.getAttribute('data-focus'));
		const title = pre.getAttribute('title');

		// Split the highlighted HTML into lines. The curated examples have no
		// tokens spanning newlines, so a plain split is safe here.
		const lines = code.innerHTML.replace(/\n$/, '').split('\n');

		const newPre = document.createElement('pre');
		newPre.className = 'cb-pre hljs';
		if (focus.size) newPre.classList.add('has-focus');
		const newCode = document.createElement('code');
		if (lang) newCode.className = 'language-' + lang;

		lines.forEach((lineHtml, i) => {
			const ln = start + i;
			const row = document.createElement('span');
			row.className = 'cb-line';
			if (hl.has(ln)) row.classList.add('hl');
			if (add.has(ln)) row.classList.add('add');
			if (del.has(ln)) row.classList.add('del');
			if (focus.has(ln)) row.classList.add('focus');
			const gutter = document.createElement('span');
			gutter.className = 'cb-gutter';
			gutter.textContent = showNumbers ? String(ln) : '';
			const content = document.createElement('span');
			content.className = 'cb-code';
			content.innerHTML = lineHtml === '' ? '​' : lineHtml;
			row.appendChild(gutter);
			row.appendChild(content);
			newCode.appendChild(row);
		});
		newPre.appendChild(newCode);

		const wrap = document.createElement('div');
		wrap.className = 'cb-wrap';
		if (title || lang) {
			const bar = document.createElement('div');
			bar.className = 'cb-titlebar';
			if (title) {
				const t = document.createElement('span');
				t.className = 'cb-title';
				t.textContent = title;
				bar.appendChild(t);
			}
			if (lang) {
				const badge = document.createElement('span');
				badge.className = 'cb-lang';
				badge.textContent = lang;
				bar.appendChild(badge);
			}
			const copy = document.createElement('button');
			copy.type = 'button';
			copy.className = 'cb-copy';
			copy.title = 'Copy';
			copy.setAttribute('aria-label', 'Copy code');
			copy.innerHTML = '<i class="bi bi-clipboard"></i>';
			copy.addEventListener('click', () => {
				navigator.clipboard.writeText(rawText).then(() => {
					copy.innerHTML = '<i class="bi bi-clipboard-check"></i>';
					copy.classList.add('copied');
					copy.title = 'Copied!';
					setTimeout(() => {
						copy.innerHTML = '<i class="bi bi-clipboard"></i>';
						copy.classList.remove('copied');
						copy.title = 'Copy';
					}, 1200);
				});
			});
			bar.appendChild(copy);
			wrap.appendChild(bar);
		}
		wrap.appendChild(newPre);
		pre.replaceWith(wrap);
	}

	// Highlight the Carve source blocks normally.
	document.querySelectorAll('pre code.language-carve').forEach((el) => {
		if (window.hljs) {
			try { window.hljs.highlightElement(el); } catch (e) { /* noop */ }
		}
	});

	// Enhance every rendered code block.
	document.querySelectorAll('.cb-output pre').forEach(enhance);
})();
<?php $this->Html->scriptEnd(); ?>
