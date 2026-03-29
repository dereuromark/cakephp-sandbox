<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Payment $payment
 * @var array<string, string> $providers
 * @var array<string, string> $currencies
 * @var array<int, string> $users
 */

$this->assign('title', 'Create Payment');
?>

<div class="row">
	<div class="col-md-8">
		<h1>Create Payment</h1>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Payment Details</h5></div>
			<div class="card-body">
				<?= $this->Form->create($payment) ?>

				<?= $this->Form->control('transaction_id', [
					'type' => 'text',
					'label' => 'Transaction ID',
					'placeholder' => 'Leave empty to auto-generate',
				]) ?>

				<?= $this->Form->control('amount', [
					'type' => 'number',
					'step' => '0.01',
					'min' => '0.01',
					'default' => '99.99',
				]) ?>

				<?= $this->Form->control('currency', [
					'options' => $currencies,
					'default' => 'USD',
				]) ?>

				<?= $this->Form->control('provider', [
					'options' => $providers,
					'empty' => '-- Select Provider --',
				]) ?>

				<?= $this->Form->control('provider_reference', [
					'label' => 'Provider Reference (optional)',
					'placeholder' => 'External reference ID',
				]) ?>

				<?= $this->Form->control('user_id', [
					'options' => $users,
					'empty' => '-- Select User (optional) --',
				]) ?>

				<div class="mt-3">
					<?= $this->Form->button('Create Payment', ['class' => 'btn btn-primary']) ?>
				</div>

				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">About This Demo</h5></div>
			<div class="card-body">
				<p>This creates a payment that will go through automated verification:</p>
				<ul>
					<li>Payment starts in <strong>Pending</strong> state</li>
					<li>Click "Start Verification" to begin the process</li>
					<li>The system will automatically retry up to 3 times</li>
					<li>Each retry has a 40% chance of success (simulated)</li>
					<li>After 3 failed attempts, payment moves to <strong>Verification Failed</strong> for manual review</li>
				</ul>
				<p class="text-muted mb-0">
					<small>In production, timeouts would be handled by the Queue worker. Here you can manually trigger transitions or use "Simulate Full Flow".</small>
				</p>
			</div>
		</div>
	</div>
</div>
