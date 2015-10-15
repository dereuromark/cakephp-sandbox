<div class="page index">
<h2><?php echo __('Countries');?> and Search plugin</h2>

<div class="search-box">
<?php
echo $this->Form->create('CountryRecord');
echo $this->Form->input('search', ['placeholder' => 'Wildcards: * and ?']);
echo $this->Form->input('status', ['options' => ['' => '- does not matter -', '0' => 'Inactive', '1' => 'Active', ]]);
echo $this->Form->submit(__('Search'));
echo $this->Form->end();
?>
</div>

<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Format->icon('filter'), ['escape' => false]);?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
	<th><?php echo $this->Paginator->sort('country_code');?></th>
	<th><?php echo $this->Paginator->sort('zip_length', null, ['direction' => 'desc']);?></th>
</tr>
<?php
foreach ($countries as $country):
?>
	<tr>
		<td>
			<?php echo $this->Data->countryIcon($country['iso2']); ?>
		</td>
		<td>
			<?php echo h($country['name']); ?>
		</td>
		<td>
			<?php echo h($country['ori_name']); ?>
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

	<p>Display filtered result as <?php echo $this->Html->link('JSON', ['_ext' => 'json', '?' => $this->request->query]); ?> | <?php echo $this->Html->link('XML', ['_ext' => 'xml', '?' => $this->request->query]); ?></p>
	<p>Download filtered result as <?php echo $this->Html->link('JSON', ['_ext' => 'json', '?' => $this->request->query + ['download' => 1]]); ?> | <?php echo $this->Html->link('XML', ['_ext' => 'xml', '?' => $this->request->query + ['download' => 1]]); ?></p>
</div>

<br />
<span class="keyList"><?php echo __('Legend');?></span>
<ul class="keyList">
<li><?php echo $this->Data->countryIcon(null); ?> = Default Icon</li>
</ul>
