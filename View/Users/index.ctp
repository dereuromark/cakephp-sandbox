<div class="users index">
<h1><?php echo __('Users');?></h1>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></p>
<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('lastlogin');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th><?php echo $this->Paginator->sort('logins');?></th>
	<th><?php echo $this->Paginator->sort('username');?></th>
	<th><?php echo $this->Paginator->sort('email');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['lastlogin']; ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($user['User']['created']); ?>
		</td>
		<td>
			<?php echo $user['User']['logins']; ?>
		</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action'=>'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action'=>'edit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action'=>'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New User'), array('action'=>'add')); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Roles')), array('controller'=> 'roles', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New First Role'), array('controller'=> 'roles', 'action'=>'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Infos'), array('controller'=> 'user_infos', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Info'), array('controller'=> 'user_infos', 'action'=>'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresses Addresstypes'), array('controller'=> 'addresses_addresstypes', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Addresses Addresstype'), array('controller'=> 'addresses_addresstypes', 'action'=>'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Chat Entries'), array('controller'=> 'chat_entries', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Chat Entry'), array('controller'=> 'chat_entries', 'action'=>'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Email Entries'), array('controller'=> 'email_entries', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Email Entry'), array('controller'=> 'email_entries', 'action'=>'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Group Entries'), array('controller'=> 'group_entries', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Entry'), array('controller'=> 'group_entries', 'action'=>'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tag Entries'), array('controller'=> 'tag_entries', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag Entry'), array('controller'=> 'tag_entries', 'action'=>'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Telnumber Entries'), array('controller'=> 'telnumber_entries', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Telnumber Entry'), array('controller'=> 'telnumber_entries', 'action'=>'add')); ?> </li>
	</ul>
</div>