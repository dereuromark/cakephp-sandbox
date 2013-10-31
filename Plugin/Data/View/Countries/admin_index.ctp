<?php $this->Html->css('highslide/highslide', false); ?>

<?php $this->Html->script('highslide/highslide', false); ?>
<?php $this->Html->script('highslide/highslide_config', false); ?>

<div class="page index">
<h2><?php echo __('Countries');?></h2>

<table class="list">
<tr>
	<th>&nbsp;</th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
	<th><?php echo $this->Paginator->sort('country_code');?></th>
	<th><?php echo __('Coordinates');?></th>
	<th><?php echo $this->Paginator->sort('sort');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($countries as $country):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Format->countryIcon($country['Country']['iso2']); ?>
		</td>
		<td>
			<?php echo $this->Html->link($country['Country']['name'], array('controller'=>'country_provinces','action'=>'index', $country['Country']['id'])); ?>
		</td>
		<td>
			<?php echo h($country['Country']['ori_name']); ?>
		</td>
		<td>
			<?php echo $country['Country']['iso2']; ?>
		</td>
		<td>
			<?php echo $country['Country']['iso3']; ?>
		</td>
		<td>
			<?php echo '+'.$country['Country']['country_code']; ?>
		</td>

		<td>
			<?php
			$coordinates = '';
			if ((int)$country['Country']['lat'] != 0 || (int)$country['Country']['lng'] != 0) {
				$coordinates = $country['Country']['lat'].','.$country['Country']['lng'];
			}
			echo $this->Format->yesNo((int)!empty($coordinates), $coordinates, 'keine hinterlegt');

			if (!empty($coordinates)) {
				$markers = array();
				$markers[] = array('lat'=>$country['Country']['lat'],'lng'=>$country['Country']['lng'],'color'=>'green');
				$mapMarkers = $this->GoogleMapV3->staticMarkers($markers);
				echo ' '.$this->Html->link($this->Format->cIcon(ICON_DETAILS, 'Zeigen'), $this->GoogleMapV3->staticMapUrl(array('center'=>$country['Country']['lat'].','.$country['Country']['lng'],'markers'=>$mapMarkers,'size'=>'640x510','zoom'=>3)), array('id'=>'googleMap','class'=>'internal highslideImage','title'=>__('click for full map'),'escape'=>false));
			}

			?>
		</td>

		<td>
			<?php echo $country['Country']['sort']; ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($country['Country']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('up'), array('action'=>'up', $country['Country']['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('down'), array('action'=>'down', $country['Country']['id']), array('escape'=>false)); ?>
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $country['Country']['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action'=>'edit', $country['Country']['id']), array('escape'=>false)); ?>

			<?php echo $this->Html->link($this->Format->cIcon(ICON_MAP, 'Koordinaten updaten'), array('action'=>'update_coordinates', $country['Country']['id']), array('escape'=>false)); ?>

			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action'=>'delete', $country['Country']['id']), array('escape'=>false), __('Are you sure you want to delete # %s?', $country['Country']['id']),false); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('pagination', array(), array('plugin'=>'tools')); ?>

</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add %s', __('Country')), array('action'=>'add')); ?></li>
		<li><?php echo $this->Html->link(__('Update Coordinates'), array('action'=>'update_coordinates')); ?></li>
		<li><?php echo $this->Html->link(__('Icons'), array('action'=>'icons')); ?></li>
	</ul>
</div>

<br />
Hinweis:
<ul>
<li><?__('countryCodeExplanation')?></li>
</ul>

<br />
<span class="keyList">Legende:</span>
<ul class="keyList">
<li><?php echo $this->Format->countryIcon(null); ?> = Default Icon</li>
</ul>