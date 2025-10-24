<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Country $country
 * @var array $results
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/geo'); ?>
</nav>
<div class="page index col-sm-8 col-12">


<h2><?php echo __('Query {0}', __('Geo Data')); ?></h2>



	<h3>Geocoding lat/lng</h3>
	Using the Geocoder behavior you can easily auto-geocode a posted address into the corresponding `lat` and `lng` fields on save.
	<br><br>


	<?php echo $this->Form->create($country);?>
	<fieldset>
		<legend><?php echo __('Enter Postal Code, City, Address or other Geo Data'); ?></legend>
	<?php
		echo $this->Form->control('address');
		echo $this->Form->control('allow_inconclusive', ['type' => 'checkbox']);
		echo $this->Form->control('min_accuracy', []);

		// To prevent DDOS or alike
		if (PHP_SAPI !== 'cli') {
			$this->loadHelper('Captcha.Captcha');
			echo $this->Captcha->render();
		}
	?>
	</fieldset>
	<?php echo $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end();?>

<div>
<?php if ($results) { ?>
<?php
	echo pre($results);
?>
<?php } ?>
</div>

</div></div>
