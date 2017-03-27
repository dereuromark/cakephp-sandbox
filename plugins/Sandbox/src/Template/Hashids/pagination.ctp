<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page index">


	<div class="pull-right">
		<?php if ($this->request->query('debug')) { ?>
			<?php echo $this->Html->link('Disable fake debug mode', ['action' => 'pagination'], ['class' => 'btn btn-default']); ?>
		<?php } else { ?>
			<?php echo $this->Html->link('Enable fake debug mode', ['action' => 'pagination', '?' => ['debug' => 1]], ['class' => 'btn btn-primary']); ?>
		<?php } ?>
</div>


<h2><?php echo __('Countries');?> and Hashid IDs</h2>

	<table class="table list" width="100%">
		<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('iso2');?></th>
			<th><?php echo $this->Paginator->sort('iso3');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
		</tr>
		<?php
		foreach ($countries as $country):
			?>
			<tr>
				<td>
					<?php echo h($country['id']); ?>
				</td>
				<td>
					<?php echo $this->Html->link($country['name'], ['action' => 'paginationView', $country->id, '?' => $this->request->query]); ?>
				</td>
				<td>
					<?php echo h($country['iso2']); ?>
				</td>
				<td>
					<?php echo h($country['iso3']); ?>
				</td>
				<td>
					<?php echo $this->Time->nice($country['modified']); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<?php echo $this->element('Tools.pagination'); ?>

</div>


<h3>Key Goals for the Hashids and working with entities</h3>
<ul>
	<li>Same controller and view code, no need to make extra actions. Activate/Deactivate with a config switch.</li>
	<li>Auto-Debug mode feature to see the actual primary key id appended after a dash (hashid-id).</li>
</ul>
