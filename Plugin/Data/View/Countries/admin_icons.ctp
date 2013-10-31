<h2>Icons</h2>
<?php echo count($countries); ?> Länder - <?php echo count($icons); ?> Icons


<h3>contriesWithoutIcons: <b><?php echo count($contriesWithoutIcons);?></b></h3>
<ul>
<?php
	foreach ($contriesWithoutIcons as $country) {
		echo '<li>';
		echo $this->Format->countryIcon(null) . ' ' . h($country['Country']['name']) . ' (' . $country['Country']['iso2'] . ', ' . $country['Country']['iso3'] . ') ' . $this->Form->postLink($this->Format->icon('delete'), array('action' => 'delete', $country['Country']['id']), array('escape' => false), 'Sicher?');
		echo '</li>';
	}
?>
</ul>


<h3>iconsWithoutCountries: <b><?php echo count($iconsWithoutCountries);?></b></h3>
<ul>
<?php
	foreach ($iconsWithoutCountries as $icon) {
		echo '<li>';
		echo $this->Format->countryIcon($icon) . ' (' . $icon . ')';
		echo '</li>';
	}
?>
</ul>


<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Reset Cache'), array('action' => 'icons', 'reset' => 1)); ?></li>
	</ul>
</div>