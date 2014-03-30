<table class="list" width="100%">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Format->cIcon(ICON_ORDER), array('escape' => false));?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
</tr>
<?php
$i = 0;
foreach ($countries as $country):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Data->countryIcon($country['Country']['iso2']); ?>
		</td>
		<td>
			<?php echo $country['Country']['name']; ?>
		</td>
		<td>
			<?php echo $country['Country']['ori_name']; ?>
		</td>
		<td>
			<?php echo $country['Country']['iso2']; ?>
		</td>
		<td>
			<?php echo $country['Country']['iso3']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
