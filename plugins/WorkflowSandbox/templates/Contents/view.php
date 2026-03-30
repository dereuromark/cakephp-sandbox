<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Content $content
 * @var \Workflow\Engine\Definition\Definition $definition
 * @var array<string> $availableTransitions
 * @var array $users
 * @var array<\Workflow\Model\Entity\WorkflowTransition> $transitionHistory
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Content: ' . $content->title);
$currentState = $definition->getState($content->status);
?>

<div class="row">
	<div class="col-md-8"><h1><?= h($content->title) ?></h1></div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
		<?= $this->Form->postLink('Delete', ['action' => 'delete', $content->id], ['class' => 'btn btn-outline-danger', 'confirm' => 'Delete?', 'block' => true]) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Details</h5></div>
			<div class="card-body">
				<table class="table table-borderless">
					<tr><th>Author</th><td><?= h($content->user?->username ?? 'N/A') ?></td></tr>
					<tr><th>Reviewer</th><td><?= h($content->reviewer?->username ?? 'Not assigned') ?></td></tr>
					<tr>
						<th>Status</th>
						<td>
							<span class="badge fs-6" style="background-color: <?= $currentState?->getColor() ?? '#6c757d' ?>">
								<?= h($currentState?->getLabel() ?? $content->status) ?>
							</span>
						</td>
					</tr>
					<?php if ($content->rejection_reason): ?>
						<tr><th>Rejection Reason</th><td class="text-danger"><?= h($content->rejection_reason) ?></td></tr>
					<?php endif; ?>
					<?php if ($content->published_at): ?>
						<tr><th>Published</th><td><?= $content->published_at->format('Y-m-d H:i') ?></td></tr>
					<?php endif; ?>
				</table>
				<hr>
				<div><?= nl2br(h($content->body)) ?></div>
			</div>
		</div>

		<div class="card mt-3">
			<div class="card-header"><h5 class="mb-0">Transitions</h5></div>
			<div class="card-body">
				<?php if ($availableTransitions): ?>
					<?php foreach ($availableTransitions as $t): ?>
						<?php $transition = $definition->getTransition($t); ?>
						<?= $this->Form->create(null, ['url' => ['action' => 'transition', $content->id], 'class' => 'mb-2']) ?>
						<?= $this->Form->hidden('transition', ['value' => $t]) ?>
						<?php if ($t === 'assign_reviewer'): ?>
							<div class="input-group">
								<?= $this->Form->control('reviewer_id', ['options' => $users, 'empty' => '-- Reviewer --', 'label' => false, 'class' => 'form-select']) ?>
								<?= $this->Form->button('Assign Reviewer', ['class' => 'btn btn-outline-primary']) ?>
							</div>
						<?php elseif ($t === 'reject'): ?>
							<div class="input-group">
								<?= $this->Form->control('rejection_reason', ['label' => false, 'placeholder' => 'Reason...', 'class' => 'form-control']) ?>
								<?= $this->Form->button('Reject', ['class' => 'btn btn-danger']) ?>
							</div>
						<?php else: ?>
							<?= $this->Form->button(ucfirst(str_replace('_', ' ', $t)), ['class' => 'btn ' . ($transition?->isHappy() ? 'btn-success' : 'btn-outline-primary')]) ?>
						<?php endif; ?>
						<?= $this->Form->end() ?>
					<?php endforeach; ?>
				<?php else: ?>
					<p class="text-muted mb-0">No transitions available.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Workflow</h5></div>
			<div class="card-body">
				<?php $renderer = new MermaidRenderer(); ?>
				<pre class="mermaid"><?= $renderer->render($definition, $content->status) ?></pre>
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
