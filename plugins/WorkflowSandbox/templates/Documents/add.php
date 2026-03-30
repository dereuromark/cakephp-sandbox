<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Document $document
 * @var array $users
 */

$this->assign('title', 'New Document');
?>

<h1>New Document</h1>

<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<?= $this->Form->create($document) ?>
				<?= $this->Form->control('user_id', ['options' => $users, 'empty' => '-- Submitter --', 'label' => 'Submitted By']) ?>
				<?= $this->Form->control('title') ?>
				<?= $this->Form->control('file_path', ['label' => 'File Path (simulated)', 'placeholder' => '/documents/example.pdf']) ?>
				<div class="mt-3">
					<?= $this->Form->button('Create as Draft', ['class' => 'btn btn-primary']) ?>
					<?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
