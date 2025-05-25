<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\City[] $cities
 * @var array $results
 * @var mixed $sqlQuery
 * @var iterable<\Sandbox\Model\Entity\SandboxCity> $sandboxCities
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/geo'); ?>
</nav>
<div class="page index col-sm-8 col-12">


<h2><?php echo __('Query {0}', __('Geo Data')); ?></h2>


	<?php if (method_exists(\Geo\Model\Behavior\GeocoderBehavior::class, 'findSpatial')) { ?>
	<p>
		Using
		<?php echo $this->Html->link('lat/lng', ['?' => []], ['class' => 'btn btn-secondary']); ?>
		|
		<?php echo $this->Html->link('spatial coordinate (MySQL only)', ['?' => ['spatial' => true]], ['class' => 'btn btn-secondary']); ?>
	</p>
	<?php } ?>

	<h3>Distance lookup/filter</h3>
	<p>Using the Geocoder behavior you can filter by corresponding <?php echo $this->request->getQuery('spatial') ? 'spatial `coordinates`' : '`lat` and `lng`'?> fields and sort by calculated distance.
	</p>
	<p>For this example, we have a table with 130000 cities and geo coordinates to filter in.</p>


	<?php echo $this->Form->create();?>
	<fieldset>
		<legend><?php echo __('Select a city for reference'); ?></legend>
	<?php
		echo $this->Form->control('city_id');
	?>
	</fieldset>
	<?php echo $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end();?>


	<?php if ($sandboxCities) { ?>
		<h3>Result</h3>

		<p>Let's display the 10 closest cities or locations together with each distance:</p>

	<div class="">
		<table class="table table-sm table-striped">
			<thead>
			<tr>
				<th><?= __('City') ?></th>
				<th><?= __('Country') ?></th>
				<th><?= __('Coordinates') ?></th>
				<th><?= __('Distance') ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($sandboxCities as $sandboxCity): ?>
				<tr>
					<td><?= h($sandboxCity->name) ?></td>
					<td><?= $sandboxCity->hasValue('country') ? h($sandboxCity->country->name) : '' ?></td>
					<td>lat/lng <?= $this->Number->format($sandboxCity->lat) ?>, <?= $this->Number->format($sandboxCity->lng) ?></td>
					<td><?php echo $this->Number->format($sandboxCity->distance, ['precision' => 1]); ?> km</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

		<details>
			<summary>SQL Query</summary>
			<?php echo SqlFormatter::format($sqlQuery); ?>
		</details>

	<?php } ?>

</div>
