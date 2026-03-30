<?php
/**
 * @var \App\View\AppView $this
 * @var array<\WorkflowSandbox\Model\Entity\Ticket> $tickets
 * @var \Workflow\Engine\Definition\Definition $definition
 * @var array $users
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Ticket Workflow Demo');
?>

<div class="row">
	<div class="col-md-8">
		<h1>Support Ticket Workflow</h1>
		<p class="text-muted"><?= h($definition->getDescription()) ?></p>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back', ['controller' => 'WorkflowSandbox', 'action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
		<?= $this->Html->link('+ New Ticket', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-7">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="mb-0">Tickets</h5>
				<?= $this->Form->postLink('Reset All', ['action' => 'reset'], ['class' => 'btn btn-sm btn-outline-danger', 'confirm' => 'Reset?', 'block' => true]) ?>
			</div>
			<div class="card-body p-0">
				<?php if ($tickets): ?>
					<table class="table table-striped table-hover mb-0">
						<thead>
							<tr>
								<th>Ticket #</th>
								<th>Subject</th>
								<th>Priority</th>
								<th>Assignee</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($tickets as $ticket): ?>
								<tr>
									<td><?= h($ticket->ticket_number) ?></td>
									<td><?= h($ticket->subject) ?></td>
									<td>
										<?php
										$priorityColors = ['low' => 'secondary', 'medium' => 'info', 'high' => 'warning', 'urgent' => 'danger'];
										?>
										<span class="badge bg-<?= $priorityColors[$ticket->priority] ?? 'secondary' ?>">
											<?= ucfirst($ticket->priority) ?>
										</span>
									</td>
									<td><?= h($ticket->assignee?->username ?? '-') ?></td>
									<td>
										<?php $state = $definition->getState($ticket->status); ?>
										<span class="badge" style="background-color: <?= $state?->getColor() ?? '#6c757d' ?>">
											<?= h($state?->getLabel() ?? $ticket->status) ?>
										</span>
									</td>
									<td><?= $this->Html->link('View', ['action' => 'view', $ticket->id], ['class' => 'btn btn-sm btn-outline-primary']) ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="p-4 text-center text-muted">No tickets yet.</div>
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
