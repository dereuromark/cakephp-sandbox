<h2>Working with Passwords</h2>
Using the PasswordableBehavior

<?php
?>
<div class="page form">
<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo 'Demo with current password confirmation'; ?></legend>
	<?php
		echo $this->Form->input('username');
		
		echo $this->Form->input('pwd_current');
		echo $this->Form->input('pwd');
		echo $this->Form->input('pwd_repeat');
	?>
	<?php echo $this->Form->submit(__('Submit'));?>
	</fieldset>
<?php echo $this->Form->end();?>
</div>

<h3>Info</h3>
The password fields are optional, but as soon as the pwd field has content, both
are validated. Also, the current password is then required.
