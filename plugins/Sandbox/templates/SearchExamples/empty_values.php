<?php
/**
 * @var \App\View\AppView $this
 * @var array<\Data\Model\Entity\Country> $countries
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/search'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<div class="search-box pull-right" style="margin-bottom: 10px;">
		<?php
		echo $this->Form->create(null, ['valueSources' => 'query']);

		echo $this->Form->control('has_phone_code', ['options' => ['' => '- does not matter -', '0' => 'No', '1' => 'Yes']]);
		echo $this->Form->control('phone_code', ['placeholder' => 'Wildcards supported']);

		echo $this->Form->button(__('Search'), ['class' => 'btn btn-primary']);
		if ($this->Search->isSearch()) {
			echo ' ' . $this->Search->resetLink(null, ['class' => 'btn btn-secondary']);
		}

		echo $this->Form->end();
		?>
	</div>

	<h2><?php echo __('Countries');?> table and Search functionality</h2>


	<p>The URL, the paginator and the search plugin cannot work with empty values directly, so if you want to filter by all with NULL values,
		using <code>?has_phone_code=0</code> (or `no`, ...) can work here.</p>


	<table class="table list">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Icon->render('filter'), ['escape' => false]);?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
	<th><?php echo $this->Paginator->sort('phone_code');?></th>
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
			<?php echo h($country->iso2); ?>
		</td>
		<td>
			<?php echo h($country->iso3); ?>
		</td>
		<td>
			<?php echo $country->phone_code ? ('+' . h($country->phone_code)) : ''; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>

	<p>Display filtered result as <?php echo $this->Html->link('JSON', ['_ext' => 'json', '?' => $this->request->getQuery()]); ?> | <?php echo $this->Html->link('XML', ['_ext' => 'xml', '?' => $this->request->getQuery()]); ?></p>
	<p>Download filtered result as <?php echo $this->Html->link('JSON', ['_ext' => 'json', '?' => $this->request->getQuery() + ['download' => 1]]); ?> | <?php echo $this->Html->link('XML', ['_ext' => 'xml', '?' => $this->request->getQuery() + ['download' => 1]]); ?></p>
</div>
