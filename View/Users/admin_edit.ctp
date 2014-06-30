<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Edit %s', __('User'));?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('active');
		echo $this->Form->input('lastlogin');
		echo $this->Form->input('adminchange');
		echo $this->Form->input('logins');
		echo $this->Form->input('ipadr');
		echo $this->Form->input('host');
		echo $this->Form->input('user_agent');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		echo $this->Form->input('code');
		echo $this->Form->input('value');
		echo $this->Form->input('role_id');
		echo $this->Form->input('Role');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Users')), array('action' => 'index'));?></li>
	</ul>
</div>