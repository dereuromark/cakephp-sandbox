<?php
/**
 * @var \App\View\AppView $this
 * @var \Geo\View\Helper\LeafletHelper $Leaflet
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/geo'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Leaflet Maps (Open Source)</h3>

<p>
	Leaflet.js is a free, open-source alternative to Google Maps. No API key required.
</p>

<h4>Basic Map with Markers</h4>
<?php
$options = [
	'zoom' => 5,
	'lat' => 48.0,
	'lng' => 11.0,
	'div' => ['id' => 'leaflet-map-basic', 'height' => '400px'],
	'autoScript' => true,
];
echo $this->Leaflet->map($options);

$this->Leaflet->addMarker([
	'lat' => 48.69847,
	'lng' => 10.9514,
	'title' => 'Marker 1',
	'content' => 'Some Html-<b>Content</b> for the popup',
]);
$this->Leaflet->addMarker([
	'lat' => 47.69847,
	'lng' => 11.9514,
	'title' => 'Marker 2',
	'content' => 'Another popup with <i>HTML</i>',
]);
$this->Leaflet->addMarker([
	'lat' => 47.19847,
	'lng' => 11.1514,
	'title' => 'Marker 3',
]);
$this->Leaflet->finalize();
?>

<p>Click on the markers to see the popup content.</p>

<h4>Map with Polyline</h4>
<?php
$this->Leaflet->map([
	'zoom' => 6,
	'lat' => 48.0,
	'lng' => 11.0,
	'div' => ['id' => 'leaflet-map-polyline', 'height' => '300px'],
]);

$this->Leaflet->addMarker(['lat' => 48.69847, 'lng' => 10.9514, 'title' => 'Start']);
$this->Leaflet->addMarker(['lat' => 47.19847, 'lng' => 11.1514, 'title' => 'End']);

$this->Leaflet->addPolyline(
	['lat' => 48.69847, 'lng' => 10.9514],
	['lat' => 48.0, 'lng' => 11.5],
	['lat' => 47.19847, 'lng' => 11.1514],
);
$this->Leaflet->finalize();
?>

<h4>Map with Circle and Polygon</h4>
<?php
$this->Leaflet->map([
	'zoom' => 7,
	'lat' => 48.5,
	'lng' => 11.5,
	'div' => ['id' => 'leaflet-map-shapes', 'height' => '300px'],
]);

$this->Leaflet->addCircle([
	'lat' => 48.5,
	'lng' => 11.5,
	'radius' => 50000,
	'color' => '#3388ff',
	'fillColor' => '#3388ff',
	'fillOpacity' => 0.2,
]);

$this->Leaflet->addPolygon([
	['lat' => 49.0, 'lng' => 10.0],
	['lat' => 49.0, 'lng' => 11.0],
	['lat' => 48.5, 'lng' => 10.5],
], [
	'color' => '#ff0000',
	'fillColor' => '#ff0000',
	'fillOpacity' => 0.3,
]);
$this->Leaflet->finalize();
?>

<h4>Dark Theme (CartoDB Dark)</h4>
<?php
$this->Leaflet->map([
	'zoom' => 5,
	'lat' => 48.0,
	'lng' => 11.0,
	'div' => ['id' => 'leaflet-map-dark', 'height' => '300px'],
]);
$this->Leaflet->useTilePreset(\Geo\View\Helper\LeafletHelper::TILES_CARTO_DARK);

$this->Leaflet->addMarker([
	'lat' => 48.69847,
	'lng' => 10.9514,
	'title' => 'Dark Mode Marker',
	'content' => 'A marker on a dark themed map',
]);
$this->Leaflet->finalize();
?>

</div></div>
