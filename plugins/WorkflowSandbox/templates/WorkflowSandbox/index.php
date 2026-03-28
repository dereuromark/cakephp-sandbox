<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, \Workflow\Engine\Definition\Definition> $workflows
 */

$this->assign('title', 'Workflow Sandbox');
?>

<h1>Workflow Sandbox</h1>

<div class="alert alert-info">
	<p>
		This plugin demonstrates the <a href="https://github.com/dereuromark/cakephp-workflow" target="_blank">cakephp-workflow</a>
		plugin with multiple workflow examples. Each workflow showcases different features:
	</p>
	<ul class="mb-0">
		<li><strong>Registration</strong> - Auto-approval guards, Queue integration</li>
		<li><strong>Order</strong> - Multiple paths (cancel, refund), happy path marking</li>
		<li><strong>Content</strong> - Role-based review, publish/unpublish cycle</li>
		<li><strong>Ticket</strong> - Escalation, customer interaction states</li>
		<li><strong>Document</strong> - Multi-level approval chain</li>
	</ul>
</div>

<div class="row">
	<?php foreach ($workflows as $name => $definition): ?>
		<div class="col-md-6 col-lg-4 mb-4">
			<div class="card h-100">
				<div class="card-header">
					<h5 class="card-title mb-0">
						<?= h(ucfirst($name)) ?> Workflow
					</h5>
				</div>
				<div class="card-body">
					<p class="card-text text-muted">
						<?= h($definition->getDescription() ?? 'No description') ?>
					</p>
					<p class="card-text">
						<small>
							<strong>States:</strong> <?= count($definition->getStates()) ?> |
							<strong>Transitions:</strong> <?= count($definition->getTransitions()) ?>
						</small>
					</p>
				</div>
				<div class="card-footer">
					<?= $this->Html->link(
						'View Demo →',
						['controller' => ucfirst($name) . 's', 'action' => 'index'],
						['class' => 'btn btn-primary btn-sm'],
					) ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="col-md-6 col-lg-4 mb-4">
		<div class="card h-100 border-primary">
			<div class="card-header bg-primary text-white">
				<h5 class="card-title mb-0">
					<i class="fas fa-drafting-compass"></i> Interactive Builder
				</h5>
			</div>
			<div class="card-body">
				<p class="card-text">
					Experiment with workflow definitions using the interactive builder.
					Edit NEON config and see live diagram updates.
				</p>
			</div>
			<div class="card-footer">
				<?= $this->Html->link(
					'Open Builder →',
					['controller' => 'Builder', 'action' => 'index'],
					['class' => 'btn btn-primary btn-sm'],
				) ?>
			</div>
		</div>
	</div>
</div>

<hr>

<h2>Quick Links</h2>
<ul>
	<li>
		<?= $this->Html->link('Workflow Plugin Admin', ['plugin' => 'Workflow', 'controller' => 'Workflows', 'action' => 'index', 'prefix' => 'Admin']) ?>
		- View all registered workflows
	</li>
	<li>
		<a href="https://github.com/dereuromark/cakephp-workflow" target="_blank">
			cakephp-workflow on GitHub
		</a>
	</li>
</ul>
