<?php
/**
 * @var \App\View\AppView $this
 * @var array<\WorkflowSandbox\Model\Entity\Registration> $registrations
 * @var \Workflow\Engine\Definition\Definition $definition
 * @var array $users
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Registration Workflow Demo');
?>

<div class="row">
	<div class="col-md-8">
		<h1>Registration Workflow</h1>
		<p class="text-muted"><?= h($definition->getDescription()) ?></p>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back to Overview', ['controller' => 'WorkflowSandbox', 'action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
		<?= $this->Html->link('+ New Registration', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-7">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="mb-0">Registrations</h5>
				<?= $this->Form->postLink(
					'Reset All',
					['action' => 'reset'],
					['class' => 'btn btn-sm btn-outline-danger', 'confirm' => 'Reset all registrations?', 'block' => true],
				) ?>
			</div>
			<div class="card-body p-0">
				<?php if ($registrations): ?>
					<table class="table table-striped table-hover mb-0">
						<thead>
							<tr>
								<th>ID</th>
								<th>User</th>
								<th>Status</th>
								<th>Created</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($registrations as $registration): ?>
								<tr>
									<td><?= $registration->id ?></td>
									<td><?= h($registration->user?->username ?? 'N/A') ?></td>
									<td>
										<?php
										$state = $definition->getState($registration->status);
										$color = $state?->getColor() ?? '#6c757d';
										?>
										<span class="badge" style="background-color: <?= $color ?>">
											<?= h($state?->getLabel() ?? $registration->status) ?>
										</span>
									</td>
									<td><?= $registration->created?->format('Y-m-d H:i') ?></td>
									<td>
										<?= $this->Html->link('View', ['action' => 'view', $registration->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="p-4 text-center text-muted">
						No registrations yet. Create one to see the workflow in action.
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-lg-5">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0">Workflow Diagram</h5>
			</div>
			<div class="card-body">
				<?php
				$renderer = new MermaidRenderer();
				$mermaidCode = $renderer->render($definition);
				?>
				<pre class="mermaid"><?= $mermaidCode ?></pre>
			</div>
		</div>

		<div class="card mt-3">
			<div class="card-header">
				<h5 class="mb-0">States</h5>
			</div>
			<ul class="list-group list-group-flush">
				<?php foreach ($definition->getStates() as $state): ?>
					<li class="list-group-item d-flex justify-content-between align-items-center">
						<span>
							<span class="badge me-2" style="background-color: <?= $state->getColor() ?? '#6c757d' ?>">
								<?= h($state->getLabel() ?? $state->getName()) ?>
							</span>
							<?php if ($state->isInitial()): ?>
								<small class="text-muted">(initial)</small>
							<?php endif; ?>
							<?php if ($state->isFinal()): ?>
								<small class="text-muted">(final)</small>
							<?php endif; ?>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/mermaid@10.9.5/dist/mermaid.min.js"></script>
<script>mermaid.initialize({startOnLoad: true, theme: 'default'});</script>
