<div class="examples index">
<h1><?php echo __('Examples');?></h1>

<table class="table list">
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
foreach ($examples as $example):
?>
	<tr>

		<td>
			<?php echo $this->Html->link($this->Format->truncate($example['Example']['title'], 30), ['admin'=>false, 'action'=>$example['Example']['link']], ['title'=>$example['Example']['title']]); ?>
		</td>
		<td>
			<?php echo $example['Example']['link']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($this->Format->truncate($example['Codesnippet']['title'], 20), ['admin'=>false, 'controller'=> 'codesnippets', 'action'=>'view', $example['Codesnippet']['id']], ['title'=>$example['Codesnippet']['title']]); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($example['Example']['published']); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($example['Example']['modified']); ?>
		</td>
		<td>
			<?php echo $this->Format->yesNo($example['Example']['active'], ['onTitle' => 'Active', 'offTitle' => 'Inactive']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('icons/edit.gif', ['alt'=>__('Edit'),'title'=>__('Edit')]), ['action'=>'edit', $example['Example']['id']], ['escape' => false]);?>

			<?php echo $this->Html->link($this->Html->image('icons/delete.gif', ['alt'=>__('Delete'),'title'=>__('Delete')]), ['action'=>'delete', $example['Example']['id']], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $example['Example']['id'])]);?>

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
		<li><?php echo $this->Html->link(__('New Example'), ['action'=>'add']); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Codesnippets')), ['controller'=> 'codesnippets', 'action'=>'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Codesnippet'), ['controller'=> 'codesnippets', 'action'=>'add']); ?> </li>
	</ul>
</div>
