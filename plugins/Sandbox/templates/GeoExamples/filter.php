<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $sqlQuery
 * @var iterable<\Sandbox\Model\Entity\SandboxCity> $sandboxCities
 * @var bool $spatialAvailable
 * @var float|null $queryTime
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/geo'); ?>
</nav>
<div class="page index col-sm-8 col-12">


<h2><?php echo __('Query {0}', __('Geo Data')); ?></h2>

	<?php if (method_exists(\Geo\Model\Behavior\GeocoderBehavior::class, 'findSpatial')) { ?>
	<p>
		Using
		<?php echo $this->Html->link('lat/lng', ['?' => []], ['class' => 'btn btn-secondary' . (!$this->request->getQuery('spatial') ? ' active' : '')]); ?>
		|
		<?php if ($spatialAvailable) { ?>
			<?php echo $this->Html->link('spatial coordinate (MySQL only)', ['?' => ['spatial' => true]], ['class' => 'btn btn-secondary' . ($this->request->getQuery('spatial') ? ' active' : '')]); ?>
		<?php } else { ?>
			<span class="btn btn-secondary disabled" title="Requires MySQL with coordinates column">spatial coordinate (MySQL only)</span>
		<?php } ?>
	</p>
	<?php if (!$spatialAvailable) { ?>
	<div class="alert alert-info">
		Spatial queries with POINT columns and SPATIAL indexes require MySQL/MariaDB.
		The lat/lng distance finder works on all databases.
	</div>
	<?php } ?>
	<?php } ?>

	<h3>Distance lookup/filter</h3>
	<p>Using the Geocoder behavior you can filter by corresponding <?php echo ($this->request->getQuery('spatial') && $spatialAvailable) ? 'spatial `coordinates`' : '`lat` and `lng`'; ?> fields and sort by calculated distance.
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

		<p class="text-muted">
			Query executed in <?php echo $this->Number->format($queryTime, ['precision' => 2]); ?> ms
		</p>

		<details>
			<summary>SQL Query</summary>
			<?php echo SqlFormatter::format($sqlQuery); ?>
		</details>

	<?php } ?>

</div></div>
