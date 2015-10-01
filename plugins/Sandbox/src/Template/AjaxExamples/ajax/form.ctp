<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo __('Register fake action');?></legend>
	<?php
		echo $this->Form->input('username', []);
		echo $this->Form->input('email', []);
	?>
	</fieldset>

<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
