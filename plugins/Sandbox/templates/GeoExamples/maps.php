<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/geo'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Google Maps</h3>

<h4>Static Map</h4>
<?php
$m = [
	[
		'address' => '44.3,11.2',
	],
	[
		'address' => '44.2,11.1',
	],
];
$markers = $this->GoogleMap->staticMarkers($m, ['color' => 'red', 'char' => 'C', 'shadow' => 'false']);

$options = [
	'markers' => $markers,
];
echo $this->GoogleMap->staticMap($options);
?>

<h4>Dynamic Map</h4>
<?php
echo '<script src="' . $this->GoogleMap->apiUrl() . '"></script>';

$options = [
	'zoom' => 5,
	'type' => 'R',
	'geolocate' => true,
	'div' => ['id' => 'someothers'],
	'map' => ['navOptions' => ['style' => 'SMALL'], 'typeOptions' => ['style' => 'HORIZONTAL_BAR', 'pos' => 'RIGHT_CENTER']],
];
echo $this->GoogleMap->map($options);

$this->GoogleMap->addMarker(['lat' => 48.69847, 'lng' => 10.9514, 'title' => 'Marker', 'content' => 'Some Html-<b>Content</b>', 'icon' => $this->GoogleMap->iconSet('green')]);
$this->GoogleMap->addMarker(['lat' => 47.69847, 'lng' => 11.9514, 'title' => 'Marker2', 'content' => 'Some more Html-<b>Content</b>', 'icon' => $this->GoogleMap->iconSet('green', 'E')]);
$this->GoogleMap->addMarker(['lat' => 47.19847, 'lng' => 11.1514, 'title' => 'Marker3']);
$this->GoogleMap->finalize();
?>

<p>The green icons have some HTML window content which will show upon click.</p>

</div></div>
