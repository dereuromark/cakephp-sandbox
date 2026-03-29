<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Payment $payment
 * @var \Workflow\Engine\Definition\Definition $definition
 * @var array<string> $availableTransitions
 * @var array<\Workflow\Model\Entity\WorkflowTransition> $transitionHistory
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Payment: ' . $payment->transaction_id);
$currentState = $definition->getState($payment->status);
?>

<div class="row">
	<div class="col-md-8">
		<h1>Payment <?= h($payment->transaction_id) ?></h1>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
		<?= $this->Form->postLink('Delete', ['action' => 'delete', $payment->id], ['class' => 'btn btn-outline-danger', 'confirm' => 'Delete?', 'block' => true]) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Payment Details</h5></div>
			<div class="card-body">
				<table class="table table-borderless">
					<tr>
						<th style="width: 35%">Transaction ID</th>
						<td><code><?= h($payment->transaction_id) ?></code></td>
					</tr>
					<tr>
						<th>User</th>
						<td><?= h($payment->user?->username ?? '-') ?></td>
					</tr>
					<tr>
						<th>Amount</th>
						<td><strong><?= h($payment->amount) ?> <?= h($payment->currency ?? 'USD') ?></strong></td>
					</tr>
					<tr>
						<th>Provider</th>
						<td><?= h($payment->provider ?: '-') ?></td>
					</tr>
					<tr>
						<th>Status</th>
						<td>
							<span class="badge fs-6" style="background-color: <?= $currentState?->getColor() ?? '#6c757d' ?>">
								<?= h($currentState?->getLabel() ?? $payment->status) ?>
							</span>
							<?php if ($currentState?->isFinal()): ?>
								<span class="badge bg-secondary">Final</span>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th>Retry Count</th>
						<td>
							<?php if ($payment->retry_count > 0): ?>
								<span class="badge bg-warning"><?= $payment->retry_count ?> / 3</span>
							<?php else: ?>
								0 / 3
							<?php endif; ?>
						</td>
					</tr>
					<?php if ($payment->verified_at): ?>
						<tr>
							<th>Verified At</th>
							<td class="text-success"><?= $payment->verified_at->format('Y-m-d H:i:s') ?></td>
						</tr>
					<?php endif; ?>
					<?php if ($payment->failure_reason): ?>
						<tr>
							<th>Failure Reason</th>
							<td class="text-danger"><?= h($payment->failure_reason) ?></td>
						</tr>
					<?php endif; ?>
					<tr>
						<th>Created</th>
						<td><?= $payment->created?->format('Y-m-d H:i:s') ?></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="card mt-3">
			<div class="card-header"><h5 class="mb-0">Actions</h5></div>
			<div class="card-body">
				<?php if ($availableTransitions): ?>
					<div class="mb-3">
						<strong>Available Transitions:</strong>
					</div>
					<div class="d-flex flex-wrap gap-2 mb-3">
						<?php foreach ($availableTransitions as $t): ?>
							<?php
							$transition = $definition->getTransition($t);
							$btnClass = $transition?->isHappy() ? 'btn-success' : 'btn-outline-primary';
							// Override for specific payment transitions
							if ($t === 'max_retries_exceeded') {
								$btnClass = 'btn-danger';
							} elseif (str_starts_with($t, 'check_timeout_')) {
								$btnClass = 'btn-warning';
							}
							?>
							<?= $this->Form->create(null, ['url' => ['action' => 'transition', $payment->id]]) ?>
							<?= $this->Form->hidden('transition', ['value' => $t]) ?>
							<?= $this->Form->button(ucfirst(str_replace('_', ' ', $t)), ['class' => 'btn ' . $btnClass]) ?>
							<?= $this->Form->end() ?>
						<?php endforeach; ?>
					</div>
				<?php else: ?>
					<p class="text-muted mb-3">No transitions available. This is a final state.</p>
				<?php endif; ?>

				<?php if (!$currentState?->isFinal() && $payment->status !== 'pending'): ?>
					<hr>
					<div class="mt-3">
						<strong>Simulation:</strong>
						<p class="text-muted small">Run through the automated verification flow (40% success rate per check)</p>
						<?= $this->Form->create(null, ['url' => ['action' => 'simulate', $payment->id]]) ?>
						<?= $this->Form->button('▶ Simulate Full Flow', ['class' => 'btn btn-info']) ?>
						<?= $this->Form->end() ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Workflow Diagram</h5></div>
			<div class="card-body">
				<?php $renderer = new MermaidRenderer(); ?>
				<pre class="mermaid"><?= $renderer->render($definition, $payment->status) ?></pre>
				<small class="text-muted">Current state highlighted. Green path = happy path (success). Timeouts trigger automatic retries.</small>
			</div>
		</div>
	</div>
</div>

<div class="row mt-4">
	<div class="col-12">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Transition History</h5></div>
			<div class="card-body">
				<?php if ($transitionHistory): ?>
					<table class="table table-sm table-striped">
						<thead>
							<tr>
								<th>Date</th>
								<th>Transition</th>
								<th>From</th>
								<th>To</th>
								<th>Reason</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($transitionHistory as $log): ?>
								<tr>
									<td><?= $log->created->format('Y-m-d H:i:s') ?></td>
									<td><code><?= h($log->transition_name) ?></code></td>
									<td>
										<?php $fromState = $definition->getState($log->from_state); ?>
										<span class="badge" style="background-color: <?= $fromState?->getColor() ?? '#6c757d' ?>">
											<?= h($fromState?->getLabel() ?? $log->from_state) ?>
										</span>
									</td>
									<td>
										<?php $toState = $definition->getState($log->to_state); ?>
										<span class="badge" style="background-color: <?= $toState?->getColor() ?? '#6c757d' ?>">
											<?= h($toState?->getLabel() ?? $log->to_state) ?>
										</span>
									</td>
									<td><?= h($log->reason ?? '-') ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<p class="text-muted mb-0">No transitions recorded yet.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/mermaid@10.9.5/dist/mermaid.min.js"></script>
<script>
mermaid.initialize({startOnLoad: true, theme: 'default'});
document.addEventListener('DOMContentLoaded', () => {
	setTimeout(() => {
		document.querySelectorAll('.mermaid svg').forEach(svg => {
			let happyMarkerCreated = false, happyMarkerId = null;
			svg.querySelectorAll('path[style*="stroke:#2e7d32"]').forEach(path => {
				const markerMatch = path.getAttribute('marker-end')?.match(/url\(#(.+)\)/);
				if (markerMatch) {
					if (!happyMarkerCreated) {
						const marker = svg.querySelector('#' + CSS.escape(markerMatch[1]));
						if (marker) {
							happyMarkerId = markerMatch[1] + '-happy';
							const happyMarker = marker.cloneNode(true);
							happyMarker.id = happyMarkerId;
							happyMarker.querySelectorAll('path').forEach(p => p.style.fill = '#2e7d32');
							marker.parentNode.appendChild(happyMarker);
							happyMarkerCreated = true;
						}
					}
					if (happyMarkerId) path.setAttribute('marker-end', 'url(#' + happyMarkerId + ')');
				}
			});
		});
	}, 100);
});
</script>
