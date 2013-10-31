<div class="page index">
<h2><?php echo __('Countries');?></h2>

<table class="list">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Format->cIcon(ICON_ORDER), array('escape'=>false));?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
	<th><?php echo $this->Paginator->sort('country_code');?></th>
	<th><?php echo $this->Paginator->sort('zip_length');?></th>
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
			<?php echo $country['Country']['name']; ?>
		</td>
		<td>
			<?php echo $country['Country']['ori_name']; ?>
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
			<?php if (!empty($country['Country']['zip_length'])) {
				echo $country['Country']['zip_length'];
			} else {
				echo '--';
			} ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('pagination', array(), array('plugin'=>'tools')); ?>
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