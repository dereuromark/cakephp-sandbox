<div class="page index">
<h2><?php echo __('Continents');?></h2>

<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('parent_id');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($continents as $continent):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo h($continent['Continent']['name']); ?>
		</td>
		<td>
			<?php echo h($continent['Continent']['ori_name']); ?>
		</td>
		<td>
			<?php echo $this->Html->link($continent['ParentContinent']['name'], array('controller' => 'continents', 'action' => 'view', $continent['ParentContinent']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($continent['Continent']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $continent['Continent']['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action'=>'edit', $continent['Continent']['id']), array('escape'=>false)); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action'=>'delete', $continent['Continent']['id']), array('escape'=>false), __('Are you sure you want to delete # %s?', $continent['Continent']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<div class="pagination-container">
<?php echo $this->element('pagination', array(), array('plugin'=>'tools')); ?></div>

</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add %s', __('Continent')), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Continents')), array('controller' => 'continents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('controller' => 'countries', 'action' => 'index')); ?> </li>
	</ul>
</div>