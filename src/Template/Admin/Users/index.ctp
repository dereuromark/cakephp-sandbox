<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[] $users
 */
?>
<div class="users index">
<h2><?php echo __('Users');?></h2>

<table class="table list">
<tr>
	<th><?php echo $this->Paginator->sort('username');?></th>
	<th><?php echo $this->Paginator->sort('email');?></th>
	<th><?php echo $this->Paginator->sort('role_id');?></th>
	<th><?php echo $this->Paginator->sort('password');?></th>
	<th><?php echo $this->Paginator->sort('created', null, ['direction' => 'desc']);?></th>
	<th><?php echo $this->Paginator->sort('logins');?></th>

	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
foreach ($users as $user):
?>
	<tr>
		<td>
			<?php echo h($user['username']); ?>
		</td>
		<td>
			<?php echo h($user['email']); ?>
		</td>
		<td>
			<?php echo h($user->role['name']); ?>
		</td>
		<td>
			<?php echo $this->Format->yesNo((bool)$user['password']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($user['created']); ?>
		</td>
		<td>
			<?php echo $user['logins']; ?>
		</td>

		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), ['action'=>'edit', $user['id']]); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action'=>'delete', $user['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $user['id'])]); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->element('Tools.pagination'); ?>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New User'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Users')), ['controller' => 'users', 'action' => 'index']); ?> </li>
	</ul>
</div>
