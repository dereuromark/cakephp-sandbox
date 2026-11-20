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

<?= $this->element('carve/output_styles') ?>
<style>
.carve-rendered > :last-child {
	margin-bottom: 0;
}
</style>

<h2>Paragraph Interruption</h2>
<p>
	The Carve 0.2 rule: <strong>an open paragraph takes every line that is not blank</strong>, whatever it
	starts with. Such a line is a <em>lazy line</em> (C2-B-012). A <code>=&nbsp;</code> heading,
	<code>&gt;</code> quote, <code>---</code> break or <code>- </code> list marker written directly under
	text stays part of the paragraph, so a hard-wrapped line can never turn into a block by accident.
</p>
<p>
	To start a block after text, leave a blank line. Lint points out the lines that look like a block but
	read as text (<code>block-opener-without-blank-line</code>, <code>list-marker-without-blank-line</code>,
	<code>setext-heading-underline</code>).
</p>
<div class="alert alert-warning">
	<strong>Six interrupters.</strong> A few lines still end a paragraph without a blank line
	(C2-B-024), among them a <strong>table row</strong> and a <strong>list marker at an open
	list's column</strong>, so a nested sub-list needs no blank line (see the last two cases).
</div>

<div class="alert alert-info">
	Each case below is shown two ways: <strong>as typed</strong> (marker directly under the text) with its
	lint findings, and with a <strong>blank line before</strong> the marker.
</div>

<?php foreach ($rows as $row) : ?>
	<div class="card mb-3">
		<div class="card-header d-flex justify-content-between align-items-center">
			<strong><?= h($row['title']) ?></strong>
			<?php if ($row['equivalent']) : ?>
				<span class="badge bg-success" title="No blank line and a blank line produce identical output">interrupts: no blank line needed</span>
			<?php else : ?>
				<span class="badge bg-warning text-dark" title="Without a blank line the marker line is text">lazy line: blank line needed</span>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<p class="text-muted small mb-3"><?= h($row['note']) ?></p>
			<div class="row">
				<div class="col-md-6">
					<label class="form-label mb-1"><strong>As typed</strong></label>
					<pre class="bg-light border rounded p-2 mb-2"><code><?= h($row['carve']) ?></code></pre>
					<div class="carve-output carve carve-rendered border rounded p-2 mb-2"><?= $row['typedHtml'] ?></div>
					<?php foreach ($row['lint'] as $finding) : ?>
						<div class="small text-warning-emphasis mb-2"><i class="bi bi-exclamation-triangle"></i> <code><?= h($finding['rule']) ?></code> (line <?= h((string)$finding['line']) ?>): <?= h($finding['message']) ?></div>
					<?php endforeach; ?>
					<?php if ($debugMode) : ?>
						<pre class="bg-light border rounded p-2 small mb-0"><code><?= h($row['typedRaw']) ?></code></pre>
					<?php endif; ?>
				</div>
				<div class="col-md-6">
					<label class="form-label mb-1"><strong>Blank line before</strong></label>
					<pre class="bg-light border rounded p-2 mb-2"><code><?= h($row['blank']) ?></code></pre>
					<div class="carve-output carve carve-rendered border rounded p-2 mb-2"><?= $row['blankHtml'] ?></div>
					<?php if ($debugMode) : ?>
						<pre class="bg-light border rounded p-2 small mb-0"><code><?= h($row['blankRaw']) ?></code></pre>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<p class="text-muted small">
	Djot also keeps paragraphs greedy; the
	<?= $this->Html->link('Djot section', ['controller' => 'Djot', 'action' => 'interruption']) ?>
	shows its rules.
</p>

</div>
