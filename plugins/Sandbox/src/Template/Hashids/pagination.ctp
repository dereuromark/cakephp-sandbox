<div class="page index">
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
					<?php echo $this->Html->link($country['name'], ['action' => 'paginationView', $country->id]); ?>
				</td>
				<td>
					<?php echo h($country['iso2']); ?>
				</td>
				<td>
					<?php echo h($country['iso3']); ?>
				</td>
				<td>
					<?php echo $this->Time->localDate($country['modified']); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<?php echo $this->element('Tools.pagination'); ?>

</div>


<h3>Key Goals for the Hashids and working with entities</h3>
<ul>
	<li>Same controller and view code, no need to make extra actions.</li>
</ul>
