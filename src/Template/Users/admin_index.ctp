<div class="users index">
<h1><?php echo __('Users');?></h1>
<p>
<?php
echo $this->Paginator->counter([
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
]);
?></p>
<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('username');?></th>
	<th><?php echo $this->Paginator->sort('email');?></th>
	<th><?php echo $this->Paginator->sort('created', null, ['direction' => 'desc']);?></th>
	<th><?php echo $this->Paginator->sort('logins');?></th>
	
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
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($user['User']['created']); ?>
		</td>
		<td>
			<?php echo $user['User']['logins']; ?>
		</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), ['action'=>'edit', $user['User']['id']]); ?>
			<?php echo $this->Form->postLink(__('Delete'), ['action'=>'delete', $user['User']['id']], null, __('Are you sure you want to delete # {0}?', $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous'), [], null, ['class'=>'disabled']);?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next').' >>', [], null, ['class'=>'disabled']);?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New User'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Users')), ['controller' => 'users', 'action' => 'index']); ?> </li>
	</ul>
</div>