<div class="page index">
<h2><?php echo __('Countries');?> and Search plugin</h2>

<div class="search-box">
<?php
echo $this->Form->create('CountryRecord');
echo $this->Form->input('search', array('placeholder' => 'Wildcards: * and ?'));
echo $this->Form->submit(__('Search'));
echo $this->Form->end();
?>
</div>

<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Format->cIcon('filter.gif'), array('escape' => false));?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
	<th><?php echo $this->Paginator->sort('country_code');?></th>
	<th><?php echo $this->Paginator->sort('zip_length', null, array('direction' => 'desc'));?></th>
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
			<?php echo $this->Data->countryIcon($country['iso2']); ?>
		</td>
		<td>
			<?php echo $country['name']; ?>
		</td>
		<td>
			<?php echo $country['ori_name']; ?>
		</td>
		<td>
			<?php echo $country['iso2']; ?>
		</td>
		<td>
			<?php echo $country['iso3']; ?>
		</td>
		<td>
			<?php echo '+' . $country['country_code']; ?>
		</td>
		<td>
			<?php if (!empty($country['zip_length'])) {
				echo $country['zip_length'];
			} else {
				echo '--';
			} ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<br />
<span class="keyList"><?php echo __('Legend');?></span>
<ul class="keyList">
<li><?php echo $this->Data->countryIcon(null); ?> = Default Icon</li>
</ul>