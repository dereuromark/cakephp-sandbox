<?php
/**
 * @var \App\View\AppView $this
 * @var array $data
 */
?>
<h2>Geocode with CakePHP</h2>

<?php if (!empty($data)) { ?>
<h3>Result</h3>
<p><b><?php echo h($data['ExampleRecord']['formatted_address']); ?></b>
</p>
<div>
Details (<?php echo h('$data[\'ExampleRecord\'][\'geocoder_result\']'); ?>):
<?php echo pre($data['ExampleRecord']['geocoder_result']); ?>
</div>

<?php } ?>

<h3>Input your location</h3>
<?php echo $this->Form->create();?>
	<fieldset>
		<legend><?php echo __('Geocode');?></legend>
	<?php
		echo $this->Form->control('location', ['placeholder' => 'Address, postal code, city etc.']);

	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'));
echo $this->Form->end();
