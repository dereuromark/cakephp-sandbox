<h2>Register</h2>
<p>We don't want SPAM. So we need to verify your account/email.</p>


<?php echo $this->Form->create('User');?>

<h3>Create an account</h3>
<fieldset>
	<legend>Required information</legend>

	<?php
		echo $this->Form->input('username', array());
		echo $this->Form->input('email', array());

		echo $this->Form->input('pwd', array('type' => 'password'));
		echo $this->Form->input('pwd_repeat', array('type' => 'password'));
	?>
</fieldset>
<?php if (false) { ?>
<fieldset>
	<legend>Optional information</legend>
	<?php
		echo $this->Form->input('timezone', array());
		echo $this->Form->input('irc_nick', array());
	?>
</fieldset>
<?php } ?>

<?php echo $this->Form->end(__('Create account'));?>

<h3>No account yet?</h3>
<p><?php echo $this->Html->link('Create one here. For free :P', array('action' => 'register'))?></p>


<h3><?php echo __('Already registered');?>?</h3>
<?php echo $this->Html->link(__('Login'), array('action' => 'login'));