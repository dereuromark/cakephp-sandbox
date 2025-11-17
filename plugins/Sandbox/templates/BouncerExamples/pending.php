<?php
/**
 * @var \App\View\AppView $this
 * @var \Bouncer\Model\Entity\BouncerRecord[]|\Cake\Collection\CollectionInterface $pendingRecords
 */
?>

<div class="page index">
	<?= $this->element('Sandbox.bouncer_nav') ?>

	<h2><?= __('Pending Changes - Admin Review Queue') ?></h2>

	<div class="alert alert-info">
		<strong>Admin Interface:</strong> Review, approve, or reject user-submitted changes below.
	</div>

	<?php if (count($pendingRecords) === 0) { ?>
		<div class="alert alert-success">
			<strong>All caught up!</strong> There are no pending changes to review.
		</div>
		<p><?= $this->Html->link('Back to Articles', ['action' => 'articles'], ['class' => 'btn btn-primary']) ?></p>
	<?php } else { ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Type</th>
					<th>Record ID</th>
					<th>User</th>
					<th>Submitted</th>
					<th class="actions"><?= __('Actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pendingRecords as $record) { ?>
					<tr>
						<td><?= $this->Number->format($record->id) ?></td>
						<td>
							<?php if ($record->primary_key === null) { ?>
								<span class="badge bg-success">New Article</span>
							<?php } else { ?>
								<span class="badge bg-warning">Edit Article #<?= h($record->primary_key) ?></span>
							<?php } ?>
						</td>
						<td><?= $record->primary_key ? h($record->primary_key) : '<em>New</em>' ?></td>
						<td>User #<?= $this->Number->format($record->user_id) ?></td>
						<td><?= $this->Time->nice($record->created) ?></td>
						<td class="actions">
							<?= $this->Html->link(__('Review'), ['action' => 'review', $record->id], ['class' => 'btn btn-sm btn-primary']) ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="paginator">
			<?= $this->element('Tools.pagination') ?>
		</div>
	<?php } ?>
</div>
