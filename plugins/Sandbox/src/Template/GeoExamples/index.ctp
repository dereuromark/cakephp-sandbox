<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Geo Examples</h2>
<a href="https://github.com/dereuromark/cakephp-geo" target="_blank">[Source]</a>



<h3>Geocoding lat/lng</h3>
Using the Geocoder behavior you can easily auto-geocode a posted address into the corresponding `lat` and `lng` fields on save.
<br><br>
Try it:

<ul>
	<li><?php echo $this->Html->link('Geocode', ['action' => 'query'])?></li>
</ul>

<h3>Google Maps</h3>

<h4>Static Map</h4>
<?php
$m = $this->markerElements = [
	[
		'address' => '44.3,11.2',
	],
	[
		'address' => '44.2,11.1',
	]
];
$markers = $this->GoogleMap->staticMarkers($m, ['color' => 'red', 'char' => 'C', 'shadow' => 'false']);

$options = [
	'markers' => $markers
];
echo $this->GoogleMap->staticMap($options);
?>

<h4>Dynamic Map</h4>
<?php
echo '<script src="'.$this->GoogleMap->apiUrl().'"></script>';

$options = [
	'zoom' => 5,
	'type' => 'R',
	'geolocate' => true,
	'div' => ['id' => 'someothers'],
	'map' => ['navOptions' => ['style' => 'SMALL'], 'typeOptions' => ['style' => 'HORIZONTAL_BAR', 'pos' => 'RIGHT_CENTER']]
];
$result = $this->GoogleMap->map($options);
$this->GoogleMap->addMarker(['lat' => 48.69847, 'lng' => 10.9514, 'title' => 'Marker', 'content' => 'Some Html-<b>Content</b>', 'icon' => $this->GoogleMap->iconSet('green')]);

$this->GoogleMap->addMarker(['lat' => 47.69847, 'lng' => 11.9514, 'title' => 'Marker2', 'content' => 'Some more Html-<b>Content</b>', 'icon' => $this->GoogleMap->iconSet('green', 'E')]);

$this->GoogleMap->addMarker(['lat' => 47.19847, 'lng' => 11.1514, 'title' => 'Marker3']);

$result .= $this->GoogleMap->script();
echo $result;
?>

<p>The green icons have some HTML window content which will show upon click.</p>
