<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxArticle $article
 */
?>

<div class="page form">
	<?= $this->element('Sandbox.bouncer_nav') ?>

	<h2><?= __('Edit Article - Propose Changes') ?></h2>

	<div class="alert alert-info">
		<strong>Approval Required:</strong> Changes to existing articles require approval.
		Your edits will be saved as a draft and sent to the moderation queue.
	</div>

	<?= $this->Form->create($article) ?>
	<fieldset>
		<legend><?= __('Edit Article #' . $article->id) ?></legend>
		<?php
			echo $this->Form->control('title', [
				'required' => true,
				'label' => 'Article Title',
			]);
			echo $this->Form->control('content', [
				'type' => 'textarea',
				'rows' => 10,
				'required' => true,
				'label' => 'Article Content',
			]);
			echo $this->Form->control('status', [
				'required' => true,
				'label' => 'Status',
			]);
			echo $this->Form->control('user_id', [
				'type' => 'hidden',
				'value' => $article->user_id ?: 1,
			]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit Changes for Approval'), ['class' => 'btn btn-primary']) ?>
	<?= $this->Form->end() ?>

	<div class="mt-3">
		<?= $this->Html->link(__('Cancel'), ['action' => 'view', $article->id], ['class' => 'btn btn-secondary']) ?>
	</div>
</div>
