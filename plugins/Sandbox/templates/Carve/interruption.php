<?php
/**
 * @var \App\View\AppView $this
 * @var array<int, array{title: string, note: string, carve: string, blank: string, escaped: string, typedRaw: string, blankRaw: string, escapedRaw: string, typedHtml: string, blankHtml: string, escapedHtml: string, equivalent: bool}> $rows
 * @var bool $debugMode
 */
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<style>
.carve-output table {
	width: 100%;
	margin-bottom: 0;
	color: #212529;
	border-collapse: collapse;
}
.carve-output table th,
.carve-output table td {
	padding: 0.4rem 0.5rem;
	border: 1px solid #dee2e6;
}
.carve-output table thead th {
	border-bottom: 2px solid #dee2e6;
	background-color: #f8f9fa;
}
.carve-output > :last-child {
	margin-bottom: 0;
}
</style>

<h2>Paragraph Interruption (§10)</h2>
<p>
	The (Markdown) rule: <strong>a line that begins with a block marker is that block.</strong> A
	<code>#&nbsp;</code> (hash plus a space - a bare <code>#tag</code> stays an inline tag),
	<code>&gt;</code>, <code>|</code> or <code>---</code> at the start of a
	line opens its block wherever it appears - the paragraph above does not swallow it.
</p>
<p>
	Carve paragraphs are <strong>not greedy</strong>, so a blank line before a block is optional. (The term
	"interruption" is inherited from Markdown, where paragraphs <em>are</em> greedy and a following block has
	to force a break. In Carve there is nothing to interrupt - the block just starts where it is written.)
</p>
<p>
	Djot requires that blank line - and, famously, a blank line <em>before a nested list</em> too - which trips
	people up because it does not match how anyone actually writes. Carve makes the <strong>human-centric</strong>
	choice: write the marker where you mean it, and it just works. You only reach for a blank line or a
	<code>\</code> escape when you deliberately want the opposite.
</p>
<div class="alert alert-warning">
	<strong>One exception - lists.</strong> A list (bullet or ordered) following a paragraph
	<em>does</em> need a blank line before it, so that a hard-wrapped <code>- </code> in the middle of prose
	is not silently turned into a list. <em>Nested</em> sub-lists still need no blank line (see below).
</div>

<div class="alert alert-info">
	Each case below is shown three ways: <strong>as typed</strong> (marker directly under the text),
	<strong>blank line before</strong> (identical result - the blank line is optional), and
	<strong>escaped</strong> with a leading <code>\</code> (kept literal inside the paragraph).
</div>

<?php foreach ($rows as $row) : ?>
	<div class="card mb-3">
		<div class="card-header d-flex justify-content-between align-items-center">
			<strong><?= h($row['title']) ?></strong>
			<?php if ($row['equivalent']) : ?>
				<span class="badge bg-success" title="No blank line and a blank line produce identical output">no blank line needed</span>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<p class="text-muted small mb-3"><?= h($row['note']) ?></p>
			<div class="row">
				<div class="col-md-4">
					<label class="form-label mb-1"><strong>As typed</strong> <span class="badge bg-primary">block</span></label>
					<pre class="bg-light border rounded p-2 mb-2"><code><?= h($row['carve']) ?></code></pre>
					<div class="carve-output border rounded p-2 mb-2"><?= $row['typedHtml'] ?></div>
					<?php if ($debugMode) : ?>
						<pre class="bg-light border rounded p-2 small mb-0"><code><?= h($row['typedRaw']) ?></code></pre>
					<?php endif; ?>
				</div>
				<div class="col-md-4">
					<label class="form-label mb-1"><strong>Blank line before</strong> <span class="badge bg-secondary">same</span></label>
					<pre class="bg-light border rounded p-2 mb-2"><code><?= h($row['blank']) ?></code></pre>
					<div class="carve-output border rounded p-2 mb-2"><?= $row['blankHtml'] ?></div>
					<?php if ($debugMode) : ?>
						<pre class="bg-light border rounded p-2 small mb-0"><code><?= h($row['blankRaw']) ?></code></pre>
					<?php endif; ?>
				</div>
				<div class="col-md-4">
					<label class="form-label mb-1"><strong>Escaped <code>\</code></strong> <span class="badge bg-dark">literal</span></label>
					<pre class="bg-light border rounded p-2 mb-2"><code><?= h($row['escaped']) ?></code></pre>
					<div class="carve-output border rounded p-2 mb-2"><?= $row['escapedHtml'] ?></div>
					<?php if ($debugMode) : ?>
						<pre class="bg-light border rounded p-2 small mb-0"><code><?= h($row['escapedRaw']) ?></code></pre>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<p class="text-muted small">
	Djot makes the same interruption opt-in (it keeps a greedy-paragraph mode); the
	<?= $this->Html->link('Djot section', ['controller' => 'Djot', 'action' => 'interruption']) ?>
	shows that comparison.
</p>

</div>
