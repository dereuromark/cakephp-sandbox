<?php
/**
 * @var \App\View\AppView $this
 * @var string $page
 * @var string $title
 */
?>
<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2><i class="bi bi-journal-text"></i> <?= h($title) ?></h2>

<div class="alert alert-secondary">
	<i class="bi bi-info-circle"></i>
	This is a demo stub for the <strong>Wikilinks</strong> extension. There is no real wiki -
	every <code>[[Page]]</code> link from the
	<?= $this->Html->link('Carve playground', ['action' => 'index']) ?>
	resolves here so the links are not dead.
</div>

<?php if ($page !== '') { ?>
<p class="text-muted">Requested wiki slug: <code><?= h($page) ?></code></p>
<?php } ?>

<p>
	<?= $this->Html->link('<i class="bi bi-arrow-left"></i> Back to the playground', ['action' => 'index'], ['escapeTitle' => false, 'class' => 'btn btn-outline-secondary btn-sm']) ?>
	<?= $this->Html->link('Extensions', ['action' => 'extensions'], ['class' => 'btn btn-outline-secondary btn-sm']) ?>
</p>

</div>
