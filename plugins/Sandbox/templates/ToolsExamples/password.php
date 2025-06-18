<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Working with Passwords</h2>
	<p>Using the PasswordableBehavior</p>

<?php
	$action = 'Register';
	if ($this->request->getParam('action') === 'passwordEdit') {
		$action = 'Edit';
	}
?>
<div class="page form">
<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo $action . ' Demo'; ?></legend>

		<p>Existing Demo User: <code>demo</code></p>

	<?php
		echo $this->Form->control('username', []);
		echo $this->Form->control('pwd');
		echo $this->Form->control('pwd_repeat');
	?>
	<?php echo $this->Form->submit(__('Submit'));?>
	</fieldset>
<?php echo $this->Form->end();?>
</div>

<h3>Info</h3>
<?php if ($action === 'Register') { ?>
The pwd and pwd_repeat fields are both mandatory.
<?php } else { ?>
The password fields are optional, but as soon as the pwd field has content, both
are validated.
<?php } ?>

</div>
