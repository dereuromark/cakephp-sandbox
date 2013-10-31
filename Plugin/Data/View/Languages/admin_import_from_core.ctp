<h2><?php echo __('Import %s', __('Languages')); ?></h2>

<div class="page form">
<?php echo $this->Form->create('Language');?>
	<fieldset>
		<legend><?php echo __('Add %s', __('Language')); ?></legend>
	<?php
		//echo $this->Form->input('name');
		//echo $this->Form->input('ori_name');
		//echo $this->Form->input('code');

		//echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List %s', __('Languages')), array('action' => 'index'));?></li>
	</ul>
</div>