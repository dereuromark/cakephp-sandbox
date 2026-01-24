<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array<string, mixed>> $providers
 * @var string $provider
 */

$currentProvider = $providers[$provider];
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

<div class="alert alert-info">
	<strong>Tile Provider:</strong>
	<select id="tile-provider-select" class="form-select d-inline-block w-auto ms-2" onchange="window.location.href='?provider=' + this.value">
		<?php foreach ($providers as $key => $p) { ?>
			<option value="<?= $key ?>"<?= $key === $provider ? ' selected' : '' ?>><?= h($p['name']) ?></option>
		<?php } ?>
	</select>
	<small class="text-muted ms-2">Switch to see all maps with different tile providers</small>
</div>

<h4>Basic Map with Markers</h4>
<?php
echo $this->Leaflet->map([
	'zoom' => 5,
	'lat' => 48.0,
	'lng' => 11.0,
	'div' => ['id' => 'leaflet-map-basic', 'height' => '400px'],
	'autoScript' => true,
	'tileLayer' => [
		'url' => $currentProvider['url'],
		'options' => $currentProvider['options'],
	],
]);

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
echo $this->Leaflet->map([
	'zoom' => 6,
	'lat' => 48.0,
	'lng' => 11.0,
	'div' => ['id' => 'leaflet-map-polyline', 'height' => '300px'],
	'tileLayer' => [
		'url' => $currentProvider['url'],
		'options' => $currentProvider['options'],
	],
]);

// Munich to Innsbruck route
$this->Leaflet->addMarker(['lat' => 48.1351, 'lng' => 11.5820, 'title' => 'Munich', 'content' => 'Start: Munich']);
$this->Leaflet->addMarker(['lat' => 47.2692, 'lng' => 11.4041, 'title' => 'Innsbruck', 'content' => 'End: Innsbruck']);

$this->Leaflet->addPolyline(
	['lat' => 48.1351, 'lng' => 11.5820],
	['lat' => 47.2692, 'lng' => 11.4041],
);
$this->Leaflet->finalize();
?>

<h4>Map with Circle and Polygon</h4>
<?php
echo $this->Leaflet->map([
	'zoom' => 7,
	'lat' => 48.5,
	'lng' => 11.5,
	'div' => ['id' => 'leaflet-map-shapes', 'height' => '300px'],
	'tileLayer' => [
		'url' => $currentProvider['url'],
		'options' => $currentProvider['options'],
	],
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

</div></div>
