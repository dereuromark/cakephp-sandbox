<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Account information'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('email');
	?>
	</fieldset>
	<fieldset>
		<legend>Set new password</legend>
	<?php
		echo $this->Form->input('pwd', array('type' => 'password'));
		echo $this->Form->input('pwd_repeat', array('type' => 'password'));
	?>
	</fieldset>

	<fieldset>
		<legend><?php echo __('Details'); ?></legend>
	<?php
		echo $this->Form->input('irc_nick');
		//echo $this->Form->input('timezone');

		//echo $this->Form->input('language_id');
	?>
	</fieldset>

<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete your account # {0}?', $this->Form->value('User.id'))); ?></li>
	</ul>
</div>
