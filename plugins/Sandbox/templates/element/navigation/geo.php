<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Geo plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-geo" target="_blank">[Geo Plugin]</a>
</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Geo Examples') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Index', ['action' => 'index'], ['class' => 'nav-link'])?></li>

	<li class="nav-item"><?php echo $this->Navigation->link('Maps (Google)', ['action' => 'maps'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Maps (Leaflet)', ['action' => 'leaflet'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Static Maps', ['action' => 'staticMaps'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Distance lookup/filter', ['action' => 'filter'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Geocoding', ['action' => 'query'], ['class' => 'nav-link'])?></li>
</ul>
