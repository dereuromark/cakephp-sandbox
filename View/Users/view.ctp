<div class="users view">
<h1><?php echo __('User');?></h1>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lastlogin'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['lastlogin']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Datetime->niceDate($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Datetime->niceDate($user['User']['modified']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Adminchange'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['adminchange']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Logins'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['logins']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ipadr'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['ipadr']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Host'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['host']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User Agent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['user_agent']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['value']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('First Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($user['FirstRole']['name'], array('controller'=> 'roles', 'action'=>'view', $user['FirstRole']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('User')), array('action'=>'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action'=>'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Users')), array('action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action'=>'add')); ?> </li>
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
	<div class="related">
		<h2><?php echo __('Related User Infos');?></h2>
	<?php if (!empty($user['UserInfo'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['UserInfo']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['UserInfo']['user_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Job');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['UserInfo']['job'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Hp');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['UserInfo']['hp'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Firstname');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['UserInfo']['firstname'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lastname');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['UserInfo']['lastname'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Sex');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['UserInfo']['sex'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Birthday');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['UserInfo']['birthday'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit User Info'), array('controller'=> 'user_infos', 'action'=>'edit', $user['UserInfo']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h2><?php echo __('Related Addresses Addresstypes');?></h2>
	<?php if (!empty($user['AddressesAddresstype'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Address Id'); ?></th>
		<th><?php echo __('Addresstype Id'); ?></th>
		<th><?php echo __('C O'); ?></th>
		<th><?php echo __('Info'); ?></th>
		<th><?php echo __('Cache Strasse'); ?></th>
		<th><?php echo __('Cache Plz'); ?></th>
		<th><?php echo __('Cache Wohnort'); ?></th>
		<th><?php echo __('Cache Countryid'); ?></th>
		<th><?php echo __('Cache Bundeslandid'); ?></th>
		<th><?php echo __('Cache Status'); ?></th>
		<th><?php echo __('Cache Location'); ?></th>
		<th><?php echo __('Cache Location Temp'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AddressesAddresstype'] as $addressesAddresstype):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $addressesAddresstype['id'];?></td>
			<td><?php echo $addressesAddresstype['user_id'];?></td>
			<td><?php echo $addressesAddresstype['address_id'];?></td>
			<td><?php echo $addressesAddresstype['addresstype_id'];?></td>
			<td><?php echo $addressesAddresstype['c_o'];?></td>
			<td><?php echo $addressesAddresstype['info'];?></td>
			<td><?php echo $addressesAddresstype['cache_strasse'];?></td>
			<td><?php echo $addressesAddresstype['cache_plz'];?></td>
			<td><?php echo $addressesAddresstype['cache_wohnort'];?></td>
			<td><?php echo $addressesAddresstype['cache_countryid'];?></td>
			<td><?php echo $addressesAddresstype['cache_bundeslandid'];?></td>
			<td><?php echo $addressesAddresstype['cache_status'];?></td>
			<td><?php echo $addressesAddresstype['cache_location'];?></td>
			<td><?php echo $addressesAddresstype['cache_location_temp'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller'=> 'addresses_addresstypes', 'action'=>'view', $addressesAddresstype['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller'=> 'addresses_addresstypes', 'action'=>'edit', $addressesAddresstype['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'addresses_addresstypes', 'action'=>'delete', $addressesAddresstype['id']), null, __('Are you sure you want to delete # %s?', $addressesAddresstype['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Addresses Addresstype'), array('controller'=> 'addresses_addresstypes', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h2><?php echo __('Related Chat Entries');?></h2>
	<?php if (!empty($user['ChatEntry'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Chat Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Info'); ?></th>
		<th><?php echo __('Activity'); ?></th>
		<th><?php echo __('Cache'); ?></th>
		<th><?php echo __('Cache Type'); ?></th>
		<th><?php echo __('Cache Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['ChatEntry'] as $chatEntry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $chatEntry['id'];?></td>
			<td><?php echo $chatEntry['user_id'];?></td>
			<td><?php echo $chatEntry['chat_id'];?></td>
			<td><?php echo $chatEntry['name'];?></td>
			<td><?php echo $chatEntry['info'];?></td>
			<td><?php echo $chatEntry['activity'];?></td>
			<td><?php echo $chatEntry['cache'];?></td>
			<td><?php echo $chatEntry['cache_type'];?></td>
			<td><?php echo $chatEntry['cache_status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller'=> 'chat_entries', 'action'=>'view', $chatEntry['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller'=> 'chat_entries', 'action'=>'edit', $chatEntry['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'chat_entries', 'action'=>'delete', $chatEntry['id']), null, __('Are you sure you want to delete # %s?', $chatEntry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Chat Entry'), array('controller'=> 'chat_entries', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h2><?php echo __('Related Email Entries');?></h2>
	<?php if (!empty($user['EmailEntry'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Email Id'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Info'); ?></th>
		<th><?php echo __('Main'); ?></th>
		<th><?php echo __('Lastvalid'); ?></th>
		<th><?php echo __('Email Cache'); ?></th>
		<th><?php echo __('Cache Type'); ?></th>
		<th><?php echo __('Cache Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['EmailEntry'] as $emailEntry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $emailEntry['id'];?></td>
			<td><?php echo $emailEntry['user_id'];?></td>
			<td><?php echo $emailEntry['email_id'];?></td>
			<td><?php echo $emailEntry['email'];?></td>
			<td><?php echo $emailEntry['info'];?></td>
			<td><?php echo $emailEntry['main'];?></td>
			<td><?php echo $emailEntry['lastvalid'];?></td>
			<td><?php echo $emailEntry['email_cache'];?></td>
			<td><?php echo $emailEntry['cache_type'];?></td>
			<td><?php echo $emailEntry['cache_status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller'=> 'email_entries', 'action'=>'view', $emailEntry['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller'=> 'email_entries', 'action'=>'edit', $emailEntry['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'email_entries', 'action'=>'delete', $emailEntry['id']), null, __('Are you sure you want to delete # %s?', $emailEntry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Email Entry'), array('controller'=> 'email_entries', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h2><?php echo __('Related Group Entries');?></h2>
	<?php if (!empty($user['GroupEntry'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['GroupEntry'] as $groupEntry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $groupEntry['id'];?></td>
			<td><?php echo $groupEntry['user_id'];?></td>
			<td><?php echo $groupEntry['group_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller'=> 'group_entries', 'action'=>'view', $groupEntry['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller'=> 'group_entries', 'action'=>'edit', $groupEntry['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'group_entries', 'action'=>'delete', $groupEntry['id']), null, __('Are you sure you want to delete # %s?', $groupEntry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Group Entry'), array('controller'=> 'group_entries', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h2><?php echo __('Related Tag Entries');?></h2>
	<?php if (!empty($user['TagEntry'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Tag Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['TagEntry'] as $tagEntry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $tagEntry['id'];?></td>
			<td><?php echo $tagEntry['user_id'];?></td>
			<td><?php echo $tagEntry['tag_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller'=> 'tag_entries', 'action'=>'view', $tagEntry['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller'=> 'tag_entries', 'action'=>'edit', $tagEntry['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'tag_entries', 'action'=>'delete', $tagEntry['id']), null, __('Are you sure you want to delete # %s?', $tagEntry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Tag Entry'), array('controller'=> 'tag_entries', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h2><?php echo __('Related Telnumber Entries');?></h2>
	<?php if (!empty($user['TelnumberEntry'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Telnumber Id'); ?></th>
		<th><?php echo __('Nummer'); ?></th>
		<th><?php echo __('Info'); ?></th>
		<th><?php echo __('Address Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['TelnumberEntry'] as $telnumberEntry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $telnumberEntry['id'];?></td>
			<td><?php echo $telnumberEntry['user_id'];?></td>
			<td><?php echo $telnumberEntry['telnumber_id'];?></td>
			<td><?php echo $telnumberEntry['nummer'];?></td>
			<td><?php echo $telnumberEntry['info'];?></td>
			<td><?php echo $telnumberEntry['address_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller'=> 'telnumber_entries', 'action'=>'view', $telnumberEntry['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller'=> 'telnumber_entries', 'action'=>'edit', $telnumberEntry['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'telnumber_entries', 'action'=>'delete', $telnumberEntry['id']), null, __('Are you sure you want to delete # %s?', $telnumberEntry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Telnumber Entry'), array('controller'=> 'telnumber_entries', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h2><?php echo __('Related Roles');?></h2>
	<?php if (!empty($user['Role'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Defaultgroup'); ?></th>
		<th><?php echo __('Closed'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Role'] as $role):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $role['id'];?></td>
			<td><?php echo $role['parent_id'];?></td>
			<td><?php echo $role['name'];?></td>
			<td><?php echo $role['defaultgroup'];?></td>
			<td><?php echo $role['closed'];?></td>
			<td><?php echo $role['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller'=> 'roles', 'action'=>'view', $role['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller'=> 'roles', 'action'=>'edit', $role['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller'=> 'roles', 'action'=>'delete', $role['id']), null, __('Are you sure you want to delete # %s?', $role['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Role'), array('controller'=> 'roles', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>