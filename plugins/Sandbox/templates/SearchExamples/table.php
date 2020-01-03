<?php
/**
 * @var \App\View\AppView $this
 * @var bool $_isSearch
 * @var array $countries
 */
?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/search'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

	<div class="search-box pull-right" style="margin-bottom: 10px;">
		<?php
		echo $this->Form->create(null, ['valueSources' => 'query']);

		echo $this->Form->control('search', ['placeholder' => 'Wildcards: * and ?']);
		echo $this->Form->control('status', ['options' => ['' => '- does not matter -', '0' => 'Inactive', '1' => 'Active']]);

		echo $this->Form->button(__('Search'), ['class' => 'btn btn-primary']);
		if (!empty($_isSearch)) {
			echo ' ';
			echo $this->Html->link(__('Reset'), ['action' => 'table', '?' => array_intersect_key($this->request->getQuery(), array_flip(['sort', 'direction']))], ['class' => 'btn btn-default']);
		}

		echo $this->Form->end();
		?>
	</div>

	<h2><?php echo __('Countries');?> table and Search functionality</h2>

<table class="table list">
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

	<p>Display filtered result as <?php echo $this->Html->link('JSON', ['_ext' => 'json', '?' => $this->request->getQuery()]); ?> | <?php echo $this->Html->link('XML', ['_ext' => 'xml', '?' => $this->request->getQuery()]); ?></p>
	<p>Download filtered result as <?php echo $this->Html->link('JSON', ['_ext' => 'json', '?' => $this->request->getQuery() + ['download' => 1]]); ?> | <?php echo $this->Html->link('XML', ['_ext' => 'xml', '?' => $this->request->getQuery() + ['download' => 1]]); ?></p>
</div>
