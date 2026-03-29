<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Content $content
 * @var array $users
 */

$this->assign('title', 'New Content');
?>

<h1>New Content</h1>

<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<?= $this->Form->create($content) ?>
				<?= $this->Form->control('user_id', ['options' => $users, 'empty' => '-- Author --', 'label' => 'Author']) ?>
				<?= $this->Form->control('title') ?>
				<?= $this->Form->control('body', ['type' => 'textarea', 'rows' => 6]) ?>
				<div class="mt-3">
					<?= $this->Form->button('Create as Draft', ['class' => 'btn btn-primary']) ?>
					<?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
