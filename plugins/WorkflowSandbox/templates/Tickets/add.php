<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Ticket $ticket
 * @var array $users
 * @var array $priorities
 */

$this->assign('title', 'New Ticket');
?>

<h1>New Support Ticket</h1>

<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<?= $this->Form->create($ticket) ?>
				<?= $this->Form->control('user_id', ['options' => $users, 'empty' => '-- Submitter --', 'label' => 'Submitted By']) ?>
				<?= $this->Form->control('subject') ?>
				<?= $this->Form->control('description', ['type' => 'textarea', 'rows' => 4]) ?>
				<?= $this->Form->control('priority', ['options' => $priorities, 'default' => 'medium']) ?>
				<div class="mt-3">
					<?= $this->Form->button('Create Ticket', ['class' => 'btn btn-primary']) ?>
					<?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
