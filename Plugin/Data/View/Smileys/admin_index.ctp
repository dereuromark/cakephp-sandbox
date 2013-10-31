<div class="page index">
<h2><?php echo __('Smileys');?></h2>

<table class="list"><tr>
	<th>&nbsp;</th>
<?php if (false) { ?>
	<th><?php echo $this->Paginator->sort('smiley_cat_id');?></th>
<?php } ?>
	<th><?php echo $this->Paginator->sort('prim_code');?></th>
	<th><?php echo $this->Paginator->sort('sec_code');?></th>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th><?php echo $this->Paginator->sort('is_base');?></th>
	<th><?php echo $this->Paginator->sort('active');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($smileys as $smiley):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->imageIfExists('/tools/img/smileys/default/'.$smiley['Smiley']['smiley_path'])?>
		</td>
<?php if (false) { ?>
		<td>
			<?php echo h($smiley['Smiley']['smiley_cat_id']); ?>
		</td>
<?php } ?>
		<td>
			<?php echo h($smiley['Smiley']['prim_code']); ?>
		</td>
		<td>
			<?php echo h($smiley['Smiley']['sec_code']); ?>
		</td>
		<td>
			<?php echo h($smiley['Smiley']['title']); ?>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-is_base-<?php echo $smiley['Smiley']['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($smiley['Smiley']['is_base'], 'Ja', 'Nein'), array('action'=>'toggle', 'is_base', $smiley['Smiley']['id']), array('escape'=>false)); ?>
			</span>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-active-<?php echo $smiley['Smiley']['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($smiley['Smiley']['active'], 'Aktiv', 'Inaktiv'), array('action'=>'toggle', 'active', $smiley['Smiley']['id']), array('escape'=>false)); ?>
			</span>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($smiley['Smiley']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $smiley['Smiley']['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action'=>'edit', $smiley['Smiley']['id']), array('escape'=>false)); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action'=>'delete', $smiley['Smiley']['id']), array('escape'=>false), __('Are you sure you want to delete # %s?', $smiley['Smiley']['id'])); ?>
		</td>
	</tr>
<?php

?>
<?php endforeach; ?>
	</table>

<div class="pagination-container">
<?php echo $this->element('pagination', array(), array('plugin'=>'tools')); ?></div>

</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add %s', __('Smiley')), array('action' => 'add')); ?></li>
	</ul>
</div>