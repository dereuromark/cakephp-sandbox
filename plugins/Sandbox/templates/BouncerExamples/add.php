<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxArticle $article
 */
?>

<div class="page form">
	<?= $this->element('Sandbox.bouncer_nav') ?>

	<h2><?= __('Submit New Article') ?></h2>

	<div class="alert alert-warning">
		<strong>Note:</strong> This article will be submitted for approval. It won't be published until an admin approves it.
	</div>

	<?= $this->Form->create($article) ?>
	<fieldset>
		<?php
		echo $this->Form->control('title', ['class' => 'form-control']);
		echo $this->Form->control('content', ['type' => 'textarea', 'rows' => 10, 'class' => 'form-control']);
		echo $this->Form->control('status', [
			'options' => ['draft' => 'Draft', 'published' => 'Published'],
			'class' => 'form-control',
		]);
		echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]); // Simulated user
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit for Approval'), ['class' => 'btn btn-primary']) ?>
	<?= $this->Html->link(__('Cancel'), ['action' => 'articles'], ['class' => 'btn btn-secondary']) ?>
	<?= $this->Form->end() ?>
</div>
