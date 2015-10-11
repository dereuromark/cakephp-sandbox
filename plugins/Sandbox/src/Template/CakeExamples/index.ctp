<div class="index">
<h2><?php echo __('CakePHP Core Examples');?></h2>

<?php if (version_compare(phpversion(), '5.5', '>=')) { ?>
	<h3>Core functionality</h3>
	<ul>
		<li><?php echo $this->Html->link('Chronos (standalone DateTime extension)', ['controller' => 'ChronosExamples', 'action' => 'index'])?></li>
	</ul>
<?php } ?>

	<h3>More</h3>
<?php echo $this->element('Sandbox.actions'); ?>

</div>
