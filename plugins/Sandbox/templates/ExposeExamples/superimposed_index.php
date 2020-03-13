<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\ExposedUser[]|\Cake\Collection\CollectionInterface $exposedUsers
 */
?>
<div class="exposedUsers index content">
	<?= $this->Html->link(__('Overview'), ['action' => 'index'], ['class' => 'button float-right']) ?>

	<h3><?= __('Exposed Users through superimposition') ?></h3>

	<p>These are default CRUD actions (as Bake would generate).</p>

	<p>Note: The <code>id</code> column is now superimposed by the UUID.</p>
	<p>Also: You want to disallow sorting by <code>id</code>, <code>created</code>, <code>modified</code> if you do not want to expose the order of entry (using <code>sortWhitelist</code>).</p>

	<div class="table-responsive">
		<table class="table list">
			<thead>
				<tr>
					<th><?='ID (superimposed)' ?></th>
					<th><?= $this->Paginator->sort('name') ?></th>
					<th><?= __('Created') ?></th>
					<th><?= __('Modified') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($exposedUsers as $exposedUser): ?>
				<tr>
					<td><?= h($exposedUser->id) ?></td>
					<td><?= $this->Html->link($exposedUser->name, ['action' => 'superimposedView', $exposedUser->id]) ?></td>
					<td><?= h($exposedUser->created) ?></td>
					<td><?= h($exposedUser->modified) ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->first('<< ' . __('first')) ?>
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
			<?= $this->Paginator->last(__('last') . ' >>') ?>
		</ul>
		<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
	</div>
</div>
