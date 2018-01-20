<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
<div class="col-xs-12">
<?php echo $this->Form->create($user); ?>
	<fieldset>
		<legend><?php echo __('Account information'); ?></legend>
	<?php
		echo $this->Form->control('username');
		echo $this->Form->control('email');
	?>
	</fieldset>
	<fieldset>
		<legend>Set new password</legend>
	<?php
		echo $this->Form->control('pwd', ['type' => 'password']);
		echo $this->Form->control('pwd_repeat', ['type' => 'password']);
	?>
	</fieldset>

<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end(); ?>



</div>
</div>

<div class="row">
<div class="actions col-xs-12">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('User.id')], ['confirm' => __('Are you sure you want to delete your account # {0}?', $this->Form->value('User.id'))]); ?></li>
	</ul>
</div>
</div>
