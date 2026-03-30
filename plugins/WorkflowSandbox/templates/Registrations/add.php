<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Registration $registration
 * @var array $users
 */

$this->assign('title', 'New Registration');
?>

<h1>New Registration</h1>

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<?= $this->Form->create($registration) ?>

				<?= $this->Form->control('user_id', [
					'options' => $users,
					'empty' => '-- Select User --',
					'label' => 'User',
				]) ?>

				<?= $this->Form->control('notes', [
					'type' => 'textarea',
					'rows' => 3,
					'label' => 'Notes (optional)',
				]) ?>

				<div class="mt-3">
					<?= $this->Form->button('Create Registration', ['class' => 'btn btn-primary']) ?>
					<?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
				</div>

				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="alert alert-info">
			<h5>About this Demo</h5>
			<p>
				When you create a registration, it starts in the <strong>pending</strong> state.
				From there, you can:
			</p>
			<ul>
				<li><strong>Approve</strong> - Move to approved state</li>
				<li><strong>Reject</strong> - Move to rejected state (final)</li>
			</ul>
			<p class="mb-0">
				The workflow also supports auto-approval for moderator users via a guard condition.
			</p>
		</div>
	</div>
</div>
