<?php
/**
 * @var \App\View\AppView $this
 * @var array<\WorkflowSandbox\Model\Entity\Content> $contents
 * @var \Workflow\Engine\Definition\Definition $definition
 * @var array $users
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Content Workflow Demo');
?>

<div class="row">
	<div class="col-md-8">
		<h1>Content Moderation Workflow</h1>
		<p class="text-muted"><?= h($definition->getDescription()) ?></p>
	</div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back', ['controller' => 'WorkflowSandbox', 'action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
		<?= $this->Html->link('+ New Content', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-7">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="mb-0">Contents</h5>
				<?= $this->Form->postLink('Reset All', ['action' => 'reset'], ['class' => 'btn btn-sm btn-outline-danger', 'confirm' => 'Reset?', 'block' => true]) ?>
			</div>
			<div class="card-body p-0">
				<?php if ($contents): ?>
					<table class="table table-striped table-hover mb-0">
						<thead>
							<tr>
								<th>Title</th>
								<th>Author</th>
								<th>Reviewer</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($contents as $content): ?>
								<tr>
									<td><?= h($content->title) ?></td>
									<td><?= h($content->user?->username ?? 'N/A') ?></td>
									<td><?= h($content->reviewer?->username ?? '-') ?></td>
									<td>
										<?php $state = $definition->getState($content->status); ?>
										<span class="badge" style="background-color: <?= $state?->getColor() ?? '#6c757d' ?>">
											<?= h($state?->getLabel() ?? $content->status) ?>
										</span>
									</td>
									<td><?= $this->Html->link('View', ['action' => 'view', $content->id], ['class' => 'btn btn-sm btn-outline-primary']) ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="p-4 text-center text-muted">No contents yet.</div>
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
