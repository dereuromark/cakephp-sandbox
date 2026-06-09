<?php
/**
 * @var \App\View\AppView $this
 * @var array<int, array{title: string, note: string, djot: string, strictRaw: string, interruptRaw: string, strictHtml: string, interruptHtml: string, diverges: bool}> $rows
 * @var int $diverge
 * @var bool $debugMode
 */
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
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

<h2>Paragraph Interruption: Strict vs Interrupt</h2>
<p>
	When a block marker (<code>#</code>, <code>-</code>, <code>&gt;</code>, <code>|</code>,
	<code>---</code>) sits on the line right under paragraph text with no blank line between:
</p>
<ul>
	<li><strong>Strict</strong> (the djot default, matching the <a href="https://djot.net" target="_blank">djot spec</a>):
		the marker stays part of the paragraph - the text is preserved verbatim. A blank line is the explicit,
		lossless way to start a new block.</li>
	<li><strong>Interrupt</strong> (opt-in, markdown-like): the marker silently starts a new block, splitting
		the paragraph.</li>
</ul>

<div class="alert alert-info">
	Djot deliberately does <strong>not</strong> interrupt paragraphs by default. (Carve, by contrast, now
	makes interruption the §10 default - see the
	<?= $this->Html->link('Carve interruption page', ['controller' => 'Carve', 'action' => 'interruption']) ?>.)
	Interrupt mode is offered here for markdown-like input, but it is a trade-off: it optimizes typing
	convenience (skip a blank line) at the cost of paste-safety. Anything you mean literally can be escaped
	with a leading <code>\</code>.
</div>

<p class="lead">
	Of the <?= count($rows) ?> curated cases, interrupt diverges from the djot default in
	<strong><?= h((string)$diverge) ?></strong> - each time by reinterpreting plain prose as block structure.
</p>

<?php foreach ($rows as $row) : ?>
	<div class="card mb-3">
		<div class="card-header d-flex justify-content-between align-items-center">
			<strong><?= h($row['title']) ?></strong>
			<?php if ($row['diverges']) : ?>
				<span class="badge bg-success">djot default preserves it - interrupt splits</span>
			<?php else : ?>
				<span class="badge bg-secondary">Both modes agree</span>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<p class="text-muted small mb-2"><?= h($row['note']) ?></p>
			<label class="form-label mb-1"><strong>Djot input</strong></label>
			<pre class="bg-light border rounded p-2 mb-3"><code><?= h($row['djot']) ?></code></pre>
			<div class="row">
				<div class="col-md-6">
					<label class="form-label mb-1"><strong>Strict</strong> <span class="badge bg-success">djot default</span></label>
					<div class="carve-output border rounded p-2 mb-2"><?= $row['strictHtml'] ?></div>
					<?php if ($debugMode) : ?>
						<pre class="bg-light border rounded p-2 small mb-0"><code><?= h($row['strictRaw']) ?></code></pre>
					<?php endif; ?>
				</div>
				<div class="col-md-6">
					<label class="form-label mb-1">
						<strong>Interrupt</strong>
						<?php if ($row['diverges']) : ?>
							<span class="badge bg-danger">diverged</span>
						<?php endif; ?>
					</label>
					<div class="carve-output border rounded p-2 mb-2"><?= $row['interruptHtml'] ?></div>
					<?php if ($debugMode) : ?>
						<pre class="bg-light border rounded p-2 small mb-0"><code><?= h($row['interruptRaw']) ?></code></pre>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<p class="text-muted small">
	Run with <code>debug</code> enabled to also see the raw HTML each mode produces. The strict/interrupt switch is
	the <code>blocksInterruptParagraphs</code> option, also exposed on the
	<?= $this->Html->link('Djot Playground', ['action' => 'index']) ?>.
</p>

</div>
