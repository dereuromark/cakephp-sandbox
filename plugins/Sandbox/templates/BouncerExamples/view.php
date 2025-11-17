<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxArticle $article
 * @var bool $hasDraft
 */
?>

<div class="page view">
	<?= $this->element('Sandbox.bouncer_nav') ?>

	<?php if ($hasDraft) { ?>
		<div class="alert alert-info">
			<strong>Draft Preview:</strong> You are viewing your pending changes. This article has not been published yet and is awaiting approval.
		</div>
	<?php } ?>

	<h2><?= h($article->title) ?></h2>

	<div class="card">
		<div class="card-body">
			<dl class="row">
				<dt class="col-sm-3">ID:</dt>
				<dd class="col-sm-9"><?= $this->Number->format($article->id) ?></dd>

				<dt class="col-sm-3">Status:</dt>
				<dd class="col-sm-9"><?= h($article->status) ?></dd>

				<?php if ($article->user_id) { ?>
					<dt class="col-sm-3">Author:</dt>
					<dd class="col-sm-9">User #<?= $this->Number->format($article->user_id) ?></dd>
				<?php } ?>

				<dt class="col-sm-3">Created:</dt>
				<dd class="col-sm-9"><?= $this->Time->nice($article->created) ?></dd>

				<dt class="col-sm-3">Modified:</dt>
				<dd class="col-sm-9"><?= $this->Time->nice($article->modified) ?></dd>
			</dl>

			<hr>

			<h5>Content</h5>
			<div>
				<?= $this->Text->autoParagraph(h($article->content)) ?>
			</div>
		</div>
	</div>

	<div class="mt-3">
		<?= $this->Html->link(__('Edit Article'), ['action' => 'edit', $article->id], ['class' => 'btn btn-primary']) ?>
		<?= $this->Html->link(__('Back to Articles'), ['action' => 'articles'], ['class' => 'btn btn-secondary']) ?>
	</div>
</div>
