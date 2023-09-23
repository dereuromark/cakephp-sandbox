<?php
/**
 * @var \App\View\AppView $this
 * @var array<\Data\Model\Entity\Country> $countries
 */
?>
<div class="page index">
<h2><?php echo __('Countries');?> and AJAX Pagination</h2>

	<table class="table list" width="100%">
		<tr>
			<th><?php echo $this->Paginator->sort('sort', $this->Icon->render('filter'), ['escape' => false]);?></th>
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
					<?php echo $this->Time->nice($country->modified); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<?php echo $this->element('Tools.pagination'); ?>

</div>

<?php echo $this->Html->link('Export the current selection as CSV file', ['_ext' => 'csv', '?' => $this->request->getQuery()]); ?> | <?php echo $this->Html->link('Download the current selection as my-cool-country-list.csv file', ['_ext' => 'csv', '?' => ['download' => 1] + $this->request->getQuery()]); ?>



<h3>Key Goals for the CsvView and paginations</h3>
<ul>
	<li>Same controller code, no need to make extra actions.</li>
	<li>No additional view ctp files needed.</li>
</ul>
