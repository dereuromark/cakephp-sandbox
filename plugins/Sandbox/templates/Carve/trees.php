<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array<string, mixed>> $examples
 * @var string $extensionSource
 */

$this->append('script');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-carve.js');
$this->end();

$levels = [];
foreach ($examples as $key => $example) {
	$levels[$example['level']][$key] = $example;
}
?>

<div class="row">
<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Trees</h2>
<p>
	Markdown shows a hierarchy two ways: paste ASCII art into a code fence, or nest a bullet list
	and hope it reads. Neither gives you a tree you can link into, search, or style. Carve needs no
	new syntax for this at all - the container syntax it already has produces exactly the right
	HTML, and everything below is layered on top of that one fact.
</p>
<p>
	Each level costs a little more than the one above it. <strong>Level 0 is the whole feature for
	most documents</strong>; read on only if you need branches that fold.
</p>

<div class="alert alert-info">
	<strong>The ladder</strong>
	<ul class="mb-0">
		<li><strong>Level 0</strong> - <code>::: tree</code> and a stylesheet. No extension, no configuration, no JavaScript.</li>
		<li><strong>Level 1</strong> - one <code>addExtension()</code> call turns on the shipped <code>::: details</code> extension. Still no custom code.</li>
		<li><strong>Level 2</strong> - the Level 0 markup plus a few lines of page script, when you want clean source and no server change.</li>
		<li><strong>Level 3</strong> - a ~60-line host extension for the cleanest spelling of all. Prototype of the Tier-2 <code>Tree</code> extension proposed for the spec.</li>
	</ul>
</div>

<?php foreach ($levels as $level => $group) { ?>
<h3 class="mt-5 mb-3 pb-2 border-bottom"><?= h($level) ?></h3>

	<?php foreach ($group as $key => $example) { ?>
<div class="card mb-4" id="tree-<?= h($key) ?>">
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
				<div class="carve-rendered border rounded p-3 mb-3"><?= $example['html'] ?></div>
			</div>
		</div>
		<details>
			<summary class="text-muted small">HTML the converter produced</summary>
			<pre class="border rounded p-2 bg-light mt-2 mb-0"><code class="language-html"><?= h($example['html']) ?></code></pre>
		</details>
	</div>
</div>
	<?php } ?>
<?php } ?>

<h3 class="mt-5 mb-3 pb-2 border-bottom">The two pieces of code on this page</h3>

<div class="card mb-4">
	<div class="card-header">
		<h4 class="mb-0">Level 2 - the page script</h4>
	</div>
	<div class="card-body">
		<p class="lead">
			Runs once after load. It finds each branch of a <code>.js-collapsible</code> tree - a list
			item that has a nested list - and moves its label and children into a
			<code>&lt;details&gt;</code>. Nothing else on the page changes, and with scripting off the
			tree stays fully readable.
		</p>
<pre class="border rounded p-2 bg-light mb-0"><code class="language-javascript">document.querySelectorAll('.tree.js-collapsible li:has(> ul)').forEach(function (li) {
	var ul = li.querySelector(':scope &gt; ul');
	var details = document.createElement('details');
	var summary = document.createElement('summary');
	details.open = true;
	while (li.firstChild !== ul) {
		summary.appendChild(li.firstChild);
	}
	details.append(summary, ul);
	li.appendChild(details);
});</code></pre>
	</div>
</div>

<div class="card mb-4">
	<div class="card-header">
		<h4 class="mb-0">Level 3 - the host extension</h4>
	</div>
	<div class="card-body">
		<p class="lead">
			The whole thing. It hooks <code>render.div</code>, claims a tree that carries
			<code>.collapsible</code>, and walks the list nodes the parser already built. No parser
			change, no new AST node, no new syntax - the same container the other levels use.
		</p>
<pre class="border rounded p-2 bg-light mb-0" style="max-height: 32em; overflow: auto;"><code class="language-php"><?= h($extensionSource) ?></code></pre>
	</div>
</div>

<div class="alert alert-secondary">
	<strong>What none of this needed:</strong> a grammar production, a new AST node type, a change to
	any of the three engines, or a new editor grammar. <code>::: name</code> is core syntax that is
	always on, so an unregistered word like <code>tree</code> already renders as
	<code>&lt;div class="tree"&gt;</code> with an ordinary list inside it. Every level above is a
	rendering decision made by the host.
</div>

</div>
</div>

<?= $this->element('carve/output_styles') ?>

<script>
document.querySelectorAll('.tree.js-collapsible li:has(> ul)').forEach(function (li) {
	var ul = li.querySelector(':scope > ul');
	var details = document.createElement('details');
	var summary = document.createElement('summary');
	details.open = true;
	while (li.firstChild !== ul) {
		summary.appendChild(li.firstChild);
	}
	details.append(summary, ul);
	li.appendChild(details);
});
</script>
