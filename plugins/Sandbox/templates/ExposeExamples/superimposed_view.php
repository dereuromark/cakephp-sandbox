<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\ExposedUser $exposedUser
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/expose'); ?>
</nav>
<div class="page index col-sm-8 col-12">
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

</div></div>
