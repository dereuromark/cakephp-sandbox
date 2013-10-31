<?php $this->Html->script('highslide/highslide.js', false)?>
<?php $this->Html->script('highslide/highslide_config', false)?>

<div class="page index">

<div class="floatRight">
<?php echo __('Country');?>:&nbsp;&nbsp;
<?php echo $this->Form->input('Filter.id', array(
	'class'=>'filter',
	'label'=>false,
	'div' => false,
	'type'=>'select',
	'empty'=>array(-1=>'- [ '.__('noRestriction').' ] -'),
	'onchange'=>'changeSel(this,\''.$this->Html->url(array('action'=>'index')).'/index/\')',
	/*
	'onchange'=>'filter(this,\''.$this->Html->url(array(
				'filter'=>'on',
				'sort'=>(!empty($filters['sort']) ? $filters['sort'] : ''),
				'direction'=>(!empty($filters['direction']) ? $filters['direction'] : '')
				)).'/'.$filter_field.':\')',
	*/
	'options'=>$countries));?>
<div></div>
</div>

<h2><?php echo __('Country Provinces');?></h2>

<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('abbr');?></th>
	<th><?php echo __('Coordinates');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($countryProvinces as $countryProvince):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>

		<td>
			<?php echo $this->Format->countryIcon($countryProvince['Country']['iso2']); ?> <?php echo $this->Html->link($countryProvince['Country']['name'], array('controller'=> 'countries', 'action'=>'view', $countryProvince['Country']['id'])); ?>
		</td>
		<td>
			<?php echo h($countryProvince['CountryProvince']['name']); ?>
		</td>
		<td>
			<?php echo h($countryProvince['CountryProvince']['abbr']); ?>
		</td>

		<td>
			<?php
			$coordinates = '';
			if ((int)$countryProvince['CountryProvince']['lat'] != 0 || (int)$countryProvince['CountryProvince']['lng'] != 0) {
				$coordinates = $countryProvince['CountryProvince']['lat'].','.$countryProvince['CountryProvince']['lng'];
			}
			echo $this->Format->yesNo((int)!empty($coordinates), $coordinates, 'keine hinterlegt');

			if (!empty($coordinates)) {
				$markers = array();
				$markers[] = array('lat'=>$countryProvince['CountryProvince']['lat'],'lng'=>$countryProvince['CountryProvince']['lng'],'color'=>'green');
				$mapMarkers = $this->GoogleMapV3->staticMarkers($markers);
				echo ' '.$this->Html->link($this->Format->cIcon(ICON_DETAILS, 'Zeigen'), $this->GoogleMapV3->staticMapUrl(array('center'=>$countryProvince['CountryProvince']['lat'].','.$countryProvince['CountryProvince']['lng'],'markers'=>$mapMarkers,'size'=>'640x510','zoom'=>5)), array('id'=>'googleMap','class'=>'internal highslideImage','title'=>__('click for full map'),'escape'=>false));
			}

			?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($countryProvince['CountryProvince']['modified']); ?>
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $countryProvince['CountryProvince']['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action'=>'edit', $countryProvince['CountryProvince']['id']), array('escape'=>false)); ?>

			<?php echo $this->Html->link($this->Format->cIcon(ICON_MAP, 'Koordinaten updaten'), array('action'=>'update_coordinates', $countryProvince['CountryProvince']['id']), array('escape'=>false)); ?>

			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action'=>'delete', $countryProvince['CountryProvince']['id']), array('escape'=>false), __('Are you sure you want to delete # %s?', $countryProvince['CountryProvince']['id']),false); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('pagination', array(), array('plugin'=>'tools')); ?>
</div>

<div class="actions">
	<ul>
<?php if (true || Auth::hasRole(ROLE_SUPERADMIN)) { ?>
		<li><?php echo $this->Html->link(__('Update Coordinates'), array('action'=>'update_coordinates')); ?></li>
<?php } ?>
		<li><?php echo $this->Html->link(__('Add Country Province'), array('action'=>'add')); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('controller'=> 'countries', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add %s', __('Country')), array('controller'=> 'countries', 'action'=>'add')); ?> </li>
	</ul>
</div>