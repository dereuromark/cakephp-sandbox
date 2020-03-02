<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $exposedUser
 */
?>
<div class="row">
	<aside class="column">
		<div class="side-nav">
			<h4 class="heading"><?= __('Actions') ?></h4>
			<?= $this->Html->link(__('Back'), ['action' => 'index'], ['class' => 'button float-right']) ?>
		</div>
	</aside>
	<div class="column-responsive column-80">
		<div class="exposedUsers view content">
			<h3><?= h($exposedUser->name) ?></h3>
			<table class="table list">
				<tr>
					<th><?= __('Id') ?></th>
					<td><?= h($exposedUser->id) ?></td>
				</tr>
				<tr>
					<th><?= __('Uuid') ?></th>
					<td><?= h($exposedUser->uuid) ?></td>
				</tr>
				<tr>
					<th><?= __('Created') ?></th>
					<td><?= h($exposedUser->created) ?></td>
				</tr>
				<tr>
					<th><?= __('Modified') ?></th>
					<td><?= h($exposedUser->modified) ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
