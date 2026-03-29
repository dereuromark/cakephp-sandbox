<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Document $document
 * @var \Workflow\Engine\Definition\Definition $definition
 * @var array<string> $availableTransitions
 * @var array<\Workflow\Model\Entity\WorkflowTransition> $transitionHistory
 */

use Workflow\Renderer\MermaidRenderer;

$this->assign('title', 'Document: ' . $document->title);
$currentState = $definition->getState($document->status);
?>

<div class="row">
	<div class="col-md-8"><h1><?= h($document->title) ?></h1></div>
	<div class="col-md-4 text-end">
		<?= $this->Html->link('← Back', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
		<?= $this->Form->postLink('Delete', ['action' => 'delete', $document->id], ['class' => 'btn btn-outline-danger', 'confirm' => 'Delete?', 'block' => true]) ?>
	</div>
</div>

<div class="row mt-4">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header"><h5 class="mb-0">Details</h5></div>
			<div class="card-body">
				<table class="table table-borderless">
					<tr><th>Submitter</th><td><?= h($document->user?->username ?? 'N/A') ?></td></tr>
					<tr><th>File</th><td><?= h($document->file_path ?? 'N/A') ?></td></tr>
					<tr>
						<th>Status</th>
						<td>
							<span class="badge fs-6" style="background-color: <?= $currentState?->getColor() ?? '#6c757d' ?>">
								<?= h($currentState?->getLabel() ?? $document->status) ?>
							</span>
						</td>
					</tr>
					<tr><th>Approval Level</th><td><?= $document->current_approver_level ?>/3</td></tr>
					<?php if ($document->getApprovers()): ?>
						<tr><th>Approved By</th><td>User IDs: <?= implode(', ', $document->getApprovers()) ?></td></tr>
					<?php endif; ?>
					<?php if ($document->rejection_reason): ?>
						<tr><th>Rejection</th><td class="text-danger"><?= h($document->rejection_reason) ?></td></tr>
					<?php endif; ?>
				</table>
			</div>
		</div>

		<div class="card mt-3">
			<div class="card-header"><h5 class="mb-0">Transitions</h5></div>
			<div class="card-body">
				<?php if ($availableTransitions): ?>
					<?php foreach ($availableTransitions as $t): ?>
						<?php $transition = $definition->getTransition($t); ?>
						<?= $this->Form->create(null, ['url' => ['action' => 'transition', $document->id], 'class' => 'mb-2']) ?>
						<?= $this->Form->hidden('transition', ['value' => $t]) ?>
						<?php if ($t === 'reject'): ?>
							<div class="input-group">
								<?= $this->Form->control('rejection_reason', ['label' => false, 'placeholder' => 'Reason...', 'class' => 'form-control']) ?>
								<?= $this->Form->button('Reject', ['class' => 'btn btn-danger']) ?>
							</div>
						<?php elseif (str_starts_with($t, 'approve_level')): ?>
							<?php $level = substr($t, -1); ?>
							<?= $this->Form->button('Approve (Level ' . $level . ')', ['class' => 'btn ' . ($transition?->isHappy() ? 'btn-success' : 'btn-primary')]) ?>
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
				<pre class="mermaid"><?= $renderer->render($definition, $document->status) ?></pre>
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
// Color happy path arrowheads green after render
document.addEventListener('DOMContentLoaded', () => {
	setTimeout(() => {
		document.querySelectorAll('.mermaid svg').forEach(svg => {
			let happyMarkerCreated = false;
			let happyMarkerId = null;
			// Find paths with green stroke (happy path)
			svg.querySelectorAll('path[style*="stroke:#2e7d32"], path[style*="stroke: rgb(46, 125, 50)"]').forEach(path => {
				const markerMatch = path.getAttribute('marker-end')?.match(/url\(#(.+)\)/);
				if (markerMatch) {
					const markerId = markerMatch[1];
					if (!happyMarkerCreated) {
						const marker = svg.querySelector('#' + CSS.escape(markerId));
						if (marker) {
							happyMarkerId = markerId + '-happy';
							const happyMarker = marker.cloneNode(true);
							happyMarker.id = happyMarkerId;
							happyMarker.querySelectorAll('path').forEach(p => p.style.fill = '#2e7d32');
							marker.parentNode.appendChild(happyMarker);
							happyMarkerCreated = true;
						}
					}
					if (happyMarkerId) {
						path.setAttribute('marker-end', 'url(#' + happyMarkerId + ')');
					}
				}
			});
		});
	}, 100);
});
</script>
