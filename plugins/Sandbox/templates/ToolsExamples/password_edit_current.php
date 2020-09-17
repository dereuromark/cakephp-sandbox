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

<?php echo $this->Form->create($user);?>

	<fieldset>
 		<legend><?php echo 'Demo with current password confirmation'; ?></legend>

		<p>Demo User: <code>demo</code> - Demo User Password: <code>demo123</code></p>


		<?php
		echo $this->Form->control('username');

		echo $this->Form->control('pwd_current');
		echo $this->Form->control('pwd');
		echo $this->Form->control('pwd_repeat');
	?>
	<?php echo $this->Form->submit(__('Submit'));?>
	</fieldset>
<?php echo $this->Form->end();?>

<h3>Info</h3>
The password fields are optional, but as soon as the pwd field has content, both
are validated. Also, the current password is then required.

</div>
