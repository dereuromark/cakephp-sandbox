<?php
/**
 * @var \App\View\AppView $this
 * @var App\Model\Entity\Entity $animal
 */

// Usually these files go into a global asset file
$this->Html->script('/js/datepicker/datepicker.js', ['block' => true]);
$this->Html->script('/js/datepicker_loader.js', ['block' => true]);
$this->Html->css('/css/datepicker/datepicker.css', ['block' => true]);

// Usually, this goes into global app config.
$this->Form->setTemplates(
	[
		'dateWidget' => '<ul class="list-inline date-picker-container"><li class="day">{{day}}</li><li class="month">{{month}}</li><li class="year">{{year}}</li><li class="hour">{{hour}}</li><li class="minute">{{minute}}</li><li class="second">{{second}}</li><li class="meridian">{{meridian}}</li></ul>',
	]
);

?>
<div class="index">
<h2><?php echo __('Datepicker Examples');?></h2>
	<p>Using default select dropdowns.</p>

	<?php
	echo $this->Form->create($animal, ['align' => 'horizontal']);

	echo $this->Form->control('created', ['type' => 'date', 'label' => 'Date', 'empty' => true]);

	echo $this->Form->submit('Submit');
	echo $this->Form->end();
	?>

	<hr>

	Requirements:
	<ul>
		<li>
			This uses <a href="https://github.com/freqdec/datePicker" target="_blank">freqdec/datePicker</a> as standalone library, and as such doesn't need any JS library/framework.
			<br>
			The loader script just uses jQuery to auto-inject itself into the widget generated HTML.
		</li>
		<li>Loading the JS and CSS file.</li>
		<li>Setting up a custom <?php echo h("'dateWidget'"); ?> template for your FormHelper.</li>
	</ul>

	<hr>

	<p>Note: For (bootstrap) text inputs and datepicker, see the <?php echo $this->Html->link('Bootstrap Plugin examples', ['controller' => 'Bootstrap', 'action' => 'localized']); ?>.</p>


</div>
