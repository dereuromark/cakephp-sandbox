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
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total')
));
?></p>
<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('country_id');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('abbr');?></th>
	<th><?php echo __('Coordinates');?></th>
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
			<?php echo $this->Format->countryIcon($countryProvince['Country']['iso2']).' '.h($countryProvince['Country']['name']); ?>
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
			if ((int)$countryProvince['CountryProvince']['lat'] != 0 || (int)$countryProvince['CountryProvince']['lat'] != 0) {
				$coordinates = $countryProvince['CountryProvince']['lat'].','.$countryProvince['CountryProvince']['lat'];
			}
			echo $this->Format->yesNo((int)!empty($coordinates), $coordinates, 'keine hinterlegt');
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->first(__('first'), array());?>
 |
	<?php echo $this->Paginator->prev(__('previous'), array(), null, array('class'=>'disabled'));?>
 |
	<?php echo $this->Paginator->numbers(array('separator' => PAGINATOR_SEPARATOR));?>
 |
	<?php echo $this->Paginator->next(__('next'), array(), null, array('class'=>'disabled'));?>

 |
	<?php echo $this->Paginator->last(__('last'), array());?>
</div>


Bitte meldet fehlende/fehlerhafte Bundesländer!
<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('controller'=> 'countries', 'action'=>'index')); ?> </li>
	</ul>
</div>