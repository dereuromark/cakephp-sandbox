<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Edit {0}', __('User'));?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('active');
		echo $this->Form->input('logins');
		echo $this->Form->input('role_id');
		echo $this->Form->input('password');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('User.id')], null, __('Are you sure you want to delete # {0}?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Users')), ['action' => 'index']);?></li>
	</ul>
</div>