
<?php
foreach ($countries as $country):
?>
	<div class="country-item panel panel-body">
		<div>
			<?php echo $this->Data->countryIcon($country['iso2']); ?>
		</div>
		<div>
			<b><?php echo h($country['name']); ?></b>
		</div>
		<div>
			<?php echo h($country['iso2']); ?>
		</div>
	</div>
<?php endforeach; ?>

<?php echo $this->element('Tools.pagination'); ?>
