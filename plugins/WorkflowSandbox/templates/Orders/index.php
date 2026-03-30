<?php
/**
 * @var \App\View\AppView $this
 * @var array<\WorkflowSandbox\Model\Entity\Order> $orders
 * @var \Workflow\Engine\Definition\Definition $definition
 * @var array $users
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Order Workflow Demo');
?>

<div class="row">
	<div class="col-md-8">
		<h1>Order Workflow</h1>
		<p class="text-muted"><?= h($definition->getDescription()) ?></p>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back to Overview', ['controller' => 'WorkflowSandbox', 'action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
		<?= $this->Html->link('+ New Order', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-7">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="mb-0">Orders</h5>
				<?= $this->Form->postLink('Reset All', ['action' => 'reset'], ['class' => 'btn btn-sm btn-outline-danger', 'confirm' => 'Reset all orders?', 'block' => true]) ?>
			</div>
			<div class="card-body p-0">
				<?php if ($orders): ?>
					<table class="table table-striped table-hover mb-0">
						<thead>
							<tr>
								<th>Order #</th>
								<th>User</th>
								<th>Total</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($orders as $order): ?>
								<tr>
									<td><?= h($order->order_number) ?></td>
									<td><?= h($order->user?->username ?? 'N/A') ?></td>
									<td>$<?= number_format((float)$order->total, 2) ?></td>
									<td>
										<?php $state = $definition->getState($order->status); ?>
										<span class="badge" style="background-color: <?= $state?->getColor() ?? '#6c757d' ?>">
											<?= h($state?->getLabel() ?? $order->status) ?>
										</span>
									</td>
									<td>
										<?= $this->Html->link('View', ['action' => 'view', $order->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="p-4 text-center text-muted">No orders yet.</div>
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
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/mermaid@10.9.5/dist/mermaid.min.js"></script>
<script>mermaid.initialize({startOnLoad: true, theme: 'default'});</script>
