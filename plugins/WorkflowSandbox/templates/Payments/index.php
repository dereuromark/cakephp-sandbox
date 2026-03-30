<?php
/**
 * @var \App\View\AppView $this
 * @var array<\WorkflowSandbox\Model\Entity\Payment> $payments
 * @var \Workflow\Engine\Definition\Definition $definition
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Payment Verification Demo');
?>

<div class="row">
	<div class="col-md-8">
		<h1>Payment Verification</h1>
		<p class="text-muted"><?= h($definition->getDescription()) ?></p>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('+ Create Payment', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
		<?= $this->Html->link('← Back', ['controller' => 'WorkflowSandbox', 'action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-7">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Payments</h5></div>
			<div class="card-body p-0">
				<?php if ($payments): ?>
					<table class="table table-striped table-hover mb-0">
						<thead>
							<tr>
								<th>ID</th>
								<th>Transaction ID</th>
								<th>Amount</th>
								<th>Retries</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($payments as $payment): ?>
								<?php $state = $definition->getState($payment->status); ?>
								<tr>
									<td><?= $payment->id ?></td>
									<td><code><?= h($payment->transaction_id) ?></code></td>
									<td><?= h($payment->amount) ?> <?= h($payment->currency ?? 'USD') ?></td>
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
									<td>
										<?= $this->Html->link('View', ['action' => 'view', $payment->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="p-4 text-center text-muted">No payments yet. Create one to test the automated flow.</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-lg-5">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Workflow Diagram</h5></div>
			<div class="card-body">
				<?php $renderer = new MermaidRenderer(); ?>
				<pre class="mermaid"><?= $renderer->render($definition) ?></pre>
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
							<li>After 30s → Retry 1</li>
							<li>After 60s → Retry 2</li>
							<li>After 120s → Retry 3</li>
							<li>After 180s → Failed</li>
						</ul>
					</li>
					<li>At any point, if <code>isPaymentConfirmed</code> guard passes → Confirmed</li>
				</ol>
				<p class="mb-0"><em>In a real system, the Queue worker executes timeouts. Here you can simulate the flow.</em></p>
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
