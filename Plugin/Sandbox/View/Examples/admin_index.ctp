<div class="examples index">
<h1><?php echo __('Examples');?></h1>

<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th>Link</th>
	<th><?php echo $this->Paginator->sort('codesnippet_id');?></th>
	<th><?php echo $this->Paginator->sort('published');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
	<th><?php echo $this->Paginator->sort('active');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($examples as $example):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>

		<td>
			<?php echo $this->Html->link($this->Format->truncate($example['Example']['title'], 30), array('admin'=>false, 'action'=>$example['Example']['link']), array('title'=>$example['Example']['title'])); ?>
		</td>
		<td>
			<?php echo $example['Example']['link']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($this->Format->truncate($example['Codesnippet']['title'], 20), array('admin'=>false, 'controller'=> 'codesnippets', 'action'=>'view', $example['Codesnippet']['id']), array('title'=>$example['Codesnippet']['title'])); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($example['Example']['published']); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($example['Example']['modified']); ?>
		</td>
		<td>
			<?php echo $this->Format->yesNo($example['Example']['active'],'Active','Inactive'); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('icons/edit.gif', array('alt'=>__('Edit'),'title'=>__('Edit'))), array('action'=>'edit', $example['Example']['id']), array('escape' => false));?>

			<?php echo $this->Html->link($this->Html->image('icons/delete.gif', array('alt'=>__('Delete'),'title'=>__('Delete'))), array('action'=>'delete', $example['Example']['id']), array('escape' => false),__('Are you sure you want to delete # %s?', $example['Example']['id']));?>

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
		<li><?php echo $this->Html->link(__('New Example'), array('action'=>'add')); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Codesnippets')), array('controller'=> 'codesnippets', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Codesnippet'), array('controller'=> 'codesnippets', 'action'=>'add')); ?> </li>
	</ul>
</div>