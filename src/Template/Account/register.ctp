<h2>Register</h2>
<p>We don't want SPAM. So we need to verify your account/email.</p>


<?php echo $this->Form->create('User');?>

<h3>Create an account</h3>
<fieldset>
	<legend>Required information</legend>

	<?php
		echo $this->Form->input('username', []);
		echo $this->Form->input('email', []);

		echo $this->Form->input('pwd', ['type' => 'password']);
		echo $this->Form->input('pwd_repeat', ['type' => 'password']);
	?>
</fieldset>
<?php if (false) { ?>
<fieldset>
	<legend>Optional information</legend>
	<?php
		echo $this->Form->input('timezone', []);
		echo $this->Form->input('irc_nick', []);
	?>
</fieldset>
<?php } ?>

<?php echo $this->Form->submit(__('Create account')); echo $this->Form->end();?>

<h3>No account yet?</h3>
<p><?php echo $this->Html->link('Create one here. For free :P', ['action' => 'register'])?></p>


<h3><?php echo __('Already registered');?>?</h3>
<?php echo $this->Html->link(__('Login'), ['action' => 'login']);
