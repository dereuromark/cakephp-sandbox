<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Order $order
 * @var \Workflow\Engine\Definition\Definition $definition
 * @var array<string> $availableTransitions
 * @var array<\Workflow\Model\Entity\WorkflowTransition> $transitionHistory
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Order ' . $order->order_number);
$currentState = $definition->getState($order->status);
?>

<div class="row">
	<div class="col-md-8">
		<h1>Order <?= h($order->order_number) ?></h1>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
		<?= $this->Form->postLink('Delete', ['action' => 'delete', $order->id], ['class' => 'btn btn-outline-danger', 'confirm' => 'Delete?', 'block' => true]) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Details</h5></div>
			<div class="card-body">
				<table class="table table-borderless">
					<tr><th>Order #</th><td><?= h($order->order_number) ?></td></tr>
					<tr><th>User</th><td><?= h($order->user?->username ?? 'N/A') ?></td></tr>
					<tr><th>Total</th><td>$<?= number_format((float)$order->total, 2) ?></td></tr>
					<tr><th>Payment</th><td><?= h($order->payment_method ?? 'N/A') ?></td></tr>
					<tr>
						<th>Status</th>
						<td>
							<span class="badge fs-6" style="background-color: <?= $currentState?->getColor() ?? '#6c757d' ?>">
								<?= h($currentState?->getLabel() ?? $order->status) ?>
							</span>
						</td>
					</tr>
					<?php if ($order->paid_at): ?><tr><th>Paid</th><td><?= $order->paid_at->format('Y-m-d H:i') ?></td></tr><?php endif; ?>
					<?php if ($order->shipped_at): ?><tr><th>Shipped</th><td><?= $order->shipped_at->format('Y-m-d H:i') ?></td></tr><?php endif; ?>
					<?php if ($order->delivered_at): ?><tr><th>Delivered</th><td><?= $order->delivered_at->format('Y-m-d H:i') ?></td></tr><?php endif; ?>
				</table>
			</div>
		</div>

		<div class="card mt-3">
			<div class="card-header"><h5 class="mb-0">Transitions</h5></div>
			<div class="card-body">
				<?php if ($availableTransitions): ?>
					<div class="d-flex flex-wrap gap-2">
						<?php foreach ($availableTransitions as $t): ?>
							<?php $transition = $definition->getTransition($t); ?>
							<?= $this->Form->create(null, ['url' => ['action' => 'transition', $order->id]]) ?>
							<?= $this->Form->hidden('transition', ['value' => $t]) ?>
							<?= $this->Form->button(ucfirst(str_replace('_', ' ', $t)), ['class' => 'btn ' . ($transition?->isHappy() ? 'btn-success' : 'btn-outline-primary')]) ?>
							<?= $this->Form->end() ?>
						<?php endforeach; ?>
					</div>
				<?php else: ?>
					<p class="text-muted mb-0">No transitions available.</p>
				<?php endif; ?>
			</div>
		</div>

		<?php if ($availableTransitions): ?>
		<div class="card mt-3">
			<div class="card-header"><h5 class="mb-0">Code</h5></div>
			<div class="card-body">
				<p class="text-muted">
					The buttons above call transition names through the ORM behavior. For this order, you can invoke:
				</p>
				<?php $tabPrefix = 'transition-code-' . (int)$order->id; ?>
				<ul class="nav nav-tabs mb-3" role="tablist">
					<?php foreach ($availableTransitions as $i => $t): ?>
						<li class="nav-item" role="presentation">
							<button
								class="nav-link<?= $i === 0 ? ' active' : '' ?>"
								id="<?= h($tabPrefix . '-' . $t) ?>-tab"
								data-bs-toggle="tab"
								data-bs-target="#<?= h($tabPrefix . '-' . $t) ?>"
								type="button"
								role="tab"
								aria-controls="<?= h($tabPrefix . '-' . $t) ?>"
								aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
							>
								<code><?= h($t) ?></code>
							</button>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="tab-content">
					<?php foreach ($availableTransitions as $i => $t): ?>
						<div
							class="tab-pane fade<?= $i === 0 ? ' show active' : '' ?>"
							id="<?= h($tabPrefix . '-' . $t) ?>"
							role="tabpanel"
							aria-labelledby="<?= h($tabPrefix . '-' . $t) ?>-tab"
							tabindex="0"
						>
							<pre class="mb-0"><code><?php
echo h(sprintf(
'$order = $this->Orders->get(%d);

if ($this->Orders->canTransition($order, %s)) {
    $result = $this->Orders->applyTransition($order, %s, [
        \'reason\' => \'Manual transition\',
    ]);

    if ($result->isSuccess()) {
        $this->Orders->saveOrFail($order);
    }
}',
	(int)$order->id,
	var_export($t, true),
	var_export($t, true),
));
?></code></pre>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>

	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Workflow</h5></div>
			<div class="card-body">
				<?php $renderer = new MermaidRenderer(); ?>
				<pre class="mermaid"><?= $renderer->render($definition, $order->status) ?></pre>
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
