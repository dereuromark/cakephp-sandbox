<div class="users index">
<h1><?php echo __('Roles');?></h1>

Your Current Roles:
<?php
pr($userRoles);
?>


<br>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New RoleApplication'), array('controller' => 'roleApplications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('ApplicationHistory')), array('controller' => 'roleApplications', 'action' => 'history')); ?> </li>
		<li><?php echo $this->Html->link(__('Pending Applications'), array('controller' => 'roleApplications', 'action' => 'pending')); ?> </li>
	</ul>
</div>

You are currenctly applying for the following roles:<br>

<?php
//echo $this->render('/role_applications/user','ajax');
?>


</div>