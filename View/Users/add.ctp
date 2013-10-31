<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Add %s', __('User'));?></legend>
	<?php
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
		<li><?php echo $this->Html->link(__('List %s', __('Users')), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Roles')), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New First Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Infos'), array('controller' => 'user_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Info'), array('controller' => 'user_infos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresses Addresstypes'), array('controller' => 'addresses_addresstypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Addresses Addresstype'), array('controller' => 'addresses_addresstypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Chat Entries'), array('controller' => 'chat_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Chat Entry'), array('controller' => 'chat_entries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Email Entries'), array('controller' => 'email_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Email Entry'), array('controller' => 'email_entries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Group Entries'), array('controller' => 'group_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Entry'), array('controller' => 'group_entries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tag Entries'), array('controller' => 'tag_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag Entry'), array('controller' => 'tag_entries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Telnumber Entries'), array('controller' => 'telnumber_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Telnumber Entry'), array('controller' => 'telnumber_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>