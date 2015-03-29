<div class="page form">
<h2><?php echo __('Query {0}', __('Geo Data')); ?></h2>

<?php echo $this->Form->create($country);?>
	<fieldset>
		<legend><?php echo __('Enter Postal Code, City, Address or other Geo Data'); ?></legend>
	<?php
		echo $this->Form->input('address');
		echo $this->Form->input('allow_inconclusive', array('type' => 'checkbox'));
		echo $this->Form->input('min_accuracy', array());
	?>
	</fieldset>
	<?php echo $this->Form->submit(__('Submit')); ?>
<?php echo $this->Form->end();?>
</div>

<div>
<?php if ($results) { ?>
<?php
	echo pre($results);
?>
<?php } ?>
</div>


<div class="actions">
	<ul>

		<li><?php echo $this->Html->link(__('Back'), array('action' => 'index'));?></li>
	</ul>
</div>
