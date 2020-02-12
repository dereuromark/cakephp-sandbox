<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form">
<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo __('Add {0}', __('User'));?></legend>
	<?php
		echo $this->Form->control('username');
		echo $this->Form->control('email');
		echo $this->Form->control('active');
		echo $this->Form->control('role_id');
		echo $this->Form->control('pwd');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Users')), ['action' => 'index']);?></li>
	</ul>
</div>
