<?php
/**
 * @var \App\View\AppView $this
 * @var array<\WorkflowSandbox\Model\Entity\Payment> $payments
 * @var \Workflow\Engine\Definition\Definition $definition
 */

$this->assign('title', 'Payment Verification Demo');
?>

<div class="row">
	<div class="col-md-8">
		<h1>Payment Verification</h1>
		<p class="text-muted">Automated payment processing with timeout-based retry logic (max 3 attempts)</p>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('+ Create Payment', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
		<?= $this->Html->link('← Back', ['controller' => 'WorkflowSandbox', 'action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
	</div>
</div>

<div class="card mt-3">
	<div class="card-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Transaction ID</th>
					<th>Amount</th>
					<th>Provider</th>
					<th>Retries</th>
					<th>Status</th>
					<th>Created</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($payments): ?>
					<?php foreach ($payments as $payment): ?>
						<?php $state = $definition->getState($payment->status); ?>
						<tr>
							<td><?= $payment->id ?></td>
							<td><code><?= h($payment->transaction_id) ?></code></td>
							<td><?= h($payment->amount) ?> <?= h($payment->currency ?? 'USD') ?></td>
							<td><?= h($payment->provider ?? '-') ?></td>
							<td>
								<?php if ($payment->retry_count > 0): ?>
									<span class="badge bg-warning"><?= $payment->retry_count ?>/3</span>
								<?php else: ?>
									-
								<?php endif; ?>
							</td>
							<td>
								<span class="badge" style="background-color: <?= $state?->getColor() ?? '#6c757d' ?>">
									<?= h($state?->getLabel() ?? $payment->status) ?>
								</span>
							</td>
							<td><?= $payment->created?->format('Y-m-d H:i') ?></td>
							<td>
								<?= $this->Html->link('View', ['action' => 'view', $payment->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="8" class="text-center text-muted">No payments yet. Create one to test the automated flow.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<div class="card mt-3">
	<div class="card-header"><h5 class="mb-0">How It Works</h5></div>
	<div class="card-body">
		<p>This workflow demonstrates <strong>condition-like behavior</strong> using timeouts:</p>
		<ol>
			<li><strong>Create a payment</strong> - starts in "Pending" state</li>
			<li><strong>Start Verification</strong> - moves to "Verifying" state</li>
			<li><strong>Automatic checks</strong> via timeouts:
				<ul>
					<li>After 30s → Retry 1 (checks payment status)</li>
					<li>After 60s → Retry 2 (checks again)</li>
					<li>After 120s → Retry 3 (final attempt)</li>
					<li>After 180s → Failed (max retries exceeded)</li>
				</ul>
			</li>
			<li>At any point, if <code>isPaymentConfirmed</code> guard passes → Confirmed</li>
		</ol>
		<p class="mb-0"><em>In a real system, the Queue worker would execute these timeouts automatically. Here you can simulate the full flow.</em></p>
	</div>
</div>
