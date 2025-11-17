<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxArticle[]|\Cake\Collection\CollectionInterface $articles
 * @var array $pendingCounts
 * @var int $pendingNewCount
 */
?>

<div class="page index">
	<?= $this->element('Sandbox.bouncer_nav') ?>

	<h2><?= __('Articles') ?></h2>

	<?php if ($pendingNewCount > 0) { ?>
		<div class="alert alert-info">
			There <?= $pendingNewCount === 1 ? 'is' : 'are' ?> <strong><?= $pendingNewCount ?></strong> new article<?= $pendingNewCount === 1 ? '' : 's' ?> pending approval.
			<?= $this->Html->link('Review pending changes', ['action' => 'pending'], ['class' => 'alert-link']) ?>
		</div>
	<?php } ?>

	<div class="mb-3">
		<?= $this->Html->link('Submit New Article', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
		<?= $this->Html->link('View Pending Queue (Admin)', ['action' => 'pending'], ['class' => 'btn btn-success']) ?>
	</div>

	<table class="table table-striped">
		<thead>
			<tr>
				<th><?= $this->Paginator->sort('id') ?></th>
				<th><?= $this->Paginator->sort('title') ?></th>
				<th><?= $this->Paginator->sort('status') ?></th>
				<th><?= $this->Paginator->sort('user_id', 'Author') ?></th>
				<th><?= $this->Paginator->sort('created') ?></th>
				<th>Pending Changes</th>
				<th class="actions"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($articles as $article) { ?>
				<tr>
					<td><?= $this->Number->format($article->id) ?></td>
					<td><?= h($article->title) ?></td>
					<td><span class="badge bg-<?= $article->status === 'published' ? 'success' : 'warning' ?>"><?= h($article->status) ?></span></td>
					<td><?= $this->Number->format($article->user_id) ?></td>
					<td><?= $this->Time->nice($article->created) ?></td>
					<td>
						<?php if (isset($pendingCounts[$article->id]) && $pendingCounts[$article->id] > 0) { ?>
							<span class="badge bg-warning"><?= $pendingCounts[$article->id] ?> pending</span>
						<?php } else { ?>
							<span class="text-muted">None</span>
						<?php } ?>
					</td>
					<td class="actions">
						<?= $this->Html->link(__('View'), ['action' => 'view', $article->id], ['class' => 'btn btn-sm btn-info']) ?>
						<?= $this->Html->link(__('Edit'), ['action' => 'edit', $article->id, '?' => ['user_id' => 1]], ['class' => 'btn btn-sm btn-primary']) ?>
						<?= $this->Form->postLink(
							__('Delete'),
							['action' => 'delete', $article->id],
							[
								'confirm' => __('Request deletion of "{0}"?', $article->title),
								'class' => 'btn btn-sm btn-danger',
							]
						) ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="paginator">
		<?= $this->element('Tools.pagination') ?>
	</div>
</div>
