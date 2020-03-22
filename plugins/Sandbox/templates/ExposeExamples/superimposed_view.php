<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\ExposedUser $exposedUser
 */
?>
<div class="row">
	<aside class="column">
		<div class="side-nav">
			<h4 class="heading"><?= __('Actions') ?></h4>
			<?= $this->Html->link(__('Back'), ['action' => 'superimposedIndex'], ['class' => 'button float-right']) ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'superimposedEdit', $exposedUser->id], ['class' => 'button float-right']) ?>
		</div>
	</aside>
	<div class="column-responsive column-80">
		<div class="exposedUsers view content">
			<h3><?= h($exposedUser->name) ?></h3>

			<p>These are default CRUD actions (as Bake would generate).</p>
			<p>Note: The <code>id</code> column is now superimposed by the UUID.</p>

			<table class="table list">
				<tr>
					<th><?= __('Id (superimposed)') ?></th>
					<td><?= h($exposedUser->id) ?></td>
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
