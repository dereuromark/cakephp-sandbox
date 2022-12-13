<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Country[] $countries
 */
?>
<table class="table list" width="100%">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Format->icon('filter'), ['escape' => false]);?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name', __('Original Name'));?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
</tr>
<?php
foreach ($countries as $country):
?>
	<tr>
		<td>
			<?php echo $this->Data->countryIcon($country->iso2); ?>
		</td>
		<td>
			<?php echo h($country->name); ?>
		</td>
		<td>
			<?php echo h($country->ori_name); ?>
		</td>
		<td>
			<?php echo h($country->iso2); ?>
		</td>
		<td>
			<?php echo h($country->iso3); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination');
