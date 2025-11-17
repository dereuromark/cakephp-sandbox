<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxArticle $article
 */
?>

<div class="page form">
	<?= $this->element('Sandbox.bouncer_nav') ?>

	<h2><?= __('Admin Direct Publish') ?></h2>

	<div class="alert alert-warning">
		<strong>Admin Bypass:</strong> Articles created here are published immediately, bypassing the approval workflow.
		This is only available to administrators.
	</div>

	<?= $this->Form->create($article) ?>
	<fieldset>
		<legend><?= __('Publish Article Directly') ?></legend>
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
				'default' => 'published',
			]);
			echo $this->Form->control('user_id', [
				'type' => 'number',
				'default' => 1,
				'label' => 'Author User ID',
				'help' => 'The user ID who authored this article',
			]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Publish Now (Bypass Approval)'), ['class' => 'btn btn-primary']) ?>
	<?= $this->Form->end() ?>

	<div class="mt-3">
		<?= $this->Html->link(__('Back to Articles'), ['action' => 'articles'], ['class' => 'btn btn-secondary']) ?>
	</div>
</div>
