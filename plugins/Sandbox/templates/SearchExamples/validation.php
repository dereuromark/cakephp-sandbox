<?php
/**
 * @var \App\View\AppView $this
 * @var array<\Data\Model\Entity\Country> $countries
 * @var \Sandbox\Form\CountrySearchForm $searchForm
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/search'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<div class="search-box pull-right" style="margin-bottom: 10px;">
		<?php
		echo $this->Form->create($searchForm, ['valueSources' => ['query', 'data']]);

		echo $this->Form->control('search', ['placeholder' => 'Wildcards: * and ?']);
		echo $this->Form->control('status', ['options' => ['' => '- does not matter -', '0' => 'Inactive', '1' => 'Active']]);

		echo $this->Form->button(__('Search'), ['class' => 'btn btn-primary']);
		if ($this->Search->isSearch()) {
			echo ' ' . $this->Search->resetLink(null, ['class' => 'btn btn-secondary']);
		}

		echo $this->Form->end();
		?>
	</div>

	<h2><?php echo __('Countries');?> with Form Validation</h2>

	<?php if ($searchForm->getErrors()): ?>
	<div class="alert alert-danger">
		<?php echo __('Please fix the validation errors below.'); ?>
	</div>
	<?php endif; ?>

	<p>
		This example demonstrates the <code>formClass</code> option for the SearchComponent.
		The search form validates input using the Form class's validation rules:
	</p>
	<ul>
		<li>Search term must be at least 3 characters (or empty)</li>
		<li>Only "Active" status is allowed right now</li>
	</ul>
	<p>
		Try searching with less than 3 characters or selecting "Inactive" status to see the validation errors.
	</p>

<table class="table list">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Icon->render('filter'), ['escape' => false]);?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name', __('Original Name'));?></th>
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
			<?php echo h($country->ori_name); ?>
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

</div>
