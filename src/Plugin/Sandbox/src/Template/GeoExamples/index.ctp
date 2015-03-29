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
$m = $this->markerElements = array(
	array(
		'address' => '44.3,11.2',
	),
	array(
		'address' => '44.2,11.1',
	)
);
$markers = $this->GoogleMapV3->staticMarkers($m, array('color' => 'red', 'char' => 'C', 'shadow' => 'false'));

$options = array(
	'markers' => $markers
);
echo $this->GoogleMapV3->staticMap($options);
?>

<h4>Dynamic Map</h4>
<?php
echo '<script src="'.$this->GoogleMapV3->apiUrl().'"></script>';

$options = array(
	'zoom' => 6,
	'type' => 'R',
	'geolocate' => true,
	'div' => array('id' => 'someothers'),
	'map' => array('navOptions' => array('style' => 'SMALL'), 'typeOptions' => array('style' => 'HORIZONTAL_BAR', 'pos' => 'RIGHT_CENTER'))
);
$result = $this->GoogleMapV3->map($options);
$this->GoogleMapV3->addMarker(array('lat' => 48.69847, 'lng' => 10.9514, 'title' => 'Marker', 'content' => 'Some Html-<b>Content</b>', 'icon' => $this->GoogleMapV3->iconSet('green')));

$this->GoogleMapV3->addMarker(array('lat' => 47.69847, 'lng' => 11.9514, 'title' => 'Marker2', 'content' => 'Some more Html-<b>Content</b>', 'icon' => $this->GoogleMapV3->iconSet('green', 'E')));

$this->GoogleMapV3->addMarker(array('lat' => 47.19847, 'lng' => 11.1514, 'title' => 'Marker3'));

$result .= $this->GoogleMapV3->script();
echo $result;
?>

<p>The green icons have some HTML window content which will show upon click.</p>
