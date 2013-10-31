<div class="users roles">
<h1><?php echo __('Assign Roles to a User');?></h1>
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<br />

<div>
Current Roles:
<ul>
<?php
if (!empty($user['Role'])) {
	foreach ($user['Role'] as $role) {
		echo '<li>' . $role['name'] . '(' . $role['id'] . ') ' . $this->Format->icon('delete') . '</li>';
	}
} else {
	echo '<li><i>no roles yet</i></li>';
}
?>
</ul>
</div>
<br />

<div>
Add Roles:
<ul>
<?php
if (!empty($userRoles)) {
	foreach ($userRoles as $id => $userRole) {
		echo '' . $this->Form->input($userRole, array('type' => 'checkbox', 'value' => $id)) . '';
	}
} else {
	echo '<li><i>no more roles availible</i></li>';
}
?>
</ul>
</div>
<br />


<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('User')), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Users')), array('action' => 'index')); ?> </li>
	</ul>
</div>