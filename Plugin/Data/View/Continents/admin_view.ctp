<div class="page view">
<h2><?php echo __('Continent');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($continent['Continent']['name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ori Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($continent['Continent']['ori_name']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Parent Continent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($continent['ParentContinent']['name'], array('controller' => 'continents', 'action' => 'view', $continent['ParentContinent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo h($continent['Continent']['status']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Datetime->niceDate($continent['Continent']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('Continent')), array('action' => 'edit', $continent['Continent']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete %s', __('Continent')), array('action' => 'delete', $continent['Continent']['id']), null, __('Are you sure you want to delete # %s?', $continent['Continent']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Continents')), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Continents')), array('controller' => 'continents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('controller' => 'countries', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related %s', __('Continents'));?></h3>
	<?php if (!empty($continent['ChildContinent'])):?>
	<table class="list">	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Ori Name'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($continent['ChildContinent'] as $childContinent):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $childContinent['id'];?></td>
			<td><?php echo $childContinent['name'];?></td>
			<td><?php echo $childContinent['ori_name'];?></td>
			<td><?php echo $childContinent['parent_id'];?></td>
			<td><?php echo $childContinent['lft'];?></td>
			<td><?php echo $childContinent['rght'];?></td>
			<td><?php echo $childContinent['status'];?></td>
			<td><?php echo $childContinent['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'continents', 'action' => 'view', $childContinent['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'continents', 'action' => 'edit', $childContinent['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'continents', 'action' => 'delete', $childContinent['id']), null, __('Are you sure you want to delete # %s?', $childContinent['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Add %s', __('Child Continent')), array('controller' => 'continents', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related %s', __('Countries'));?></h3>
	<?php if (!empty($continent['Country'])):?>
	<table class="list">	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Ori Name'); ?></th>
		<th><?php echo __('Iso2'); ?></th>
		<th><?php echo __('Iso3'); ?></th>
		<th><?php echo __('Continent Id'); ?></th>
		<th><?php echo __('Country Code'); ?></th>
		<th><?php echo __('Eu Member'); ?></th>
		<th><?php echo __('Special'); ?></th>
		<th><?php echo __('Zip Length'); ?></th>
		<th><?php echo __('Zip Regexp'); ?></th>
		<th><?php echo __('Sort'); ?></th>
		<th><?php echo __('Lat'); ?></th>
		<th><?php echo __('Lng'); ?></th>
		<th><?php echo __('Address Format'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($continent['Country'] as $country):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $country['id'];?></td>
			<td><?php echo $country['name'];?></td>
			<td><?php echo $country['ori_name'];?></td>
			<td><?php echo $country['iso2'];?></td>
			<td><?php echo $country['iso3'];?></td>
			<td><?php echo $country['continent_id'];?></td>
			<td><?php echo $country['country_code'];?></td>
			<td><?php echo $country['eu_member'];?></td>
			<td><?php echo $country['special'];?></td>
			<td><?php echo $country['zip_length'];?></td>
			<td><?php echo $country['zip_regexp'];?></td>
			<td><?php echo $country['sort'];?></td>
			<td><?php echo $country['lat'];?></td>
			<td><?php echo $country['lng'];?></td>
			<td><?php echo $country['address_format'];?></td>
			<td><?php echo $country['status'];?></td>
			<td><?php echo $country['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'countries', 'action' => 'view', $country['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'countries', 'action' => 'edit', $country['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'countries', 'action' => 'delete', $country['id']), null, __('Are you sure you want to delete # %s?', $country['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Add %s', __('Country')), array('controller' => 'countries', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>