<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo __('Register fake action');?></legend>
	<?php
		echo $this->Form->control('username', []);
		echo $this->Form->control('email', []);
	?>
	</fieldset>

<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
