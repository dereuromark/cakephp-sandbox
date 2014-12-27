<h3><?php echo __('Step 3: Set a new password')?></h3>

<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Enter your new password and confirm it');?></legend>
	<?php
		echo $this->Form->input('pwd', array('type' => 'password', 'autocomplete' => 'off'));
		echo $this->Form->input('pwd_repeat', array('type' => 'password', 'autocomplete' => 'off'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li>I do remember again. <?php echo $this->Html->link(__('Abort'), array('action' => 'lost_password', '?' => array('abort' => 1)), null, __('Sure?'));?></li>
		<li><?php echo $this->Html->link(__('Login instead'), array('action' => 'login'));?></li>
	</ul>
</div>