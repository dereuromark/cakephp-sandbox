<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Register</h2>
<p>We don't want SPAM. So we need to verify your account/email.</p>


<?php echo $this->Form->create();?>

<h3>Create an account</h3>
<fieldset>
	<legend>Required information</legend>

	<?php
		echo $this->Form->control('username', []);
		echo $this->Form->control('email', []);

		echo $this->Form->control('pwd', ['type' => 'password']);
		echo $this->Form->control('pwd_repeat', ['type' => 'password']);
	?>
</fieldset>
<?php if (false) { ?>
<fieldset>
	<legend>Optional information</legend>
	<?php
		echo $this->Form->control('timezone', []);
		echo $this->Form->control('irc_nick', []);
	?>
</fieldset>
<?php } ?>

<?php echo $this->Form->submit(__('Create account')); echo $this->Form->end();?>

<h3>No account yet?</h3>
<p><?php echo $this->Html->link('Create one here. For free :P', ['action' => 'register'])?></p>


<h3><?php echo __('Already registered');?>?</h3>
<?php echo $this->Html->link(__('Login'), ['action' => 'login']);
