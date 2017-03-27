<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Working with Passwords</h2>
Using the PasswordableBehavior

<?php
	$action = 'Register';
	if ($this->request->action === 'password_edit') {
		$action = 'Edit';
	}
?>
<div class="page form">
<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo $action . ' Demo'; ?></legend>
	<?php
		echo $this->Form->input('username', []);
		echo $this->Form->input('pwd');
		echo $this->Form->input('pwd_repeat');
	?>
	<?php echo $this->Form->submit(__('Submit'));?>
	</fieldset>
<?php echo $this->Form->end();?>
</div>

<h3>Info</h3>
<?php if ($action === 'register') { ?>
The pwd and pwd_repeat fields are both mandatory.
<?php } else { ?>
The password fields are optional, but as soon as the pwd field has content, both
are validated.
<?php } ?>
