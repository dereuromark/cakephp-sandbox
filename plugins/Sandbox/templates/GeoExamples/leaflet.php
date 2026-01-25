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

<h4>Map with Auto-Center</h4>
<p>The map automatically fits all markers in view using <code>autoCenter</code>:</p>
<?php
echo $this->Leaflet->map([
	'div' => ['id' => 'leaflet-map-autocenter', 'height' => '300px'],
	'autoCenter' => true,
	'tileLayer' => [
		'url' => $currentProvider['url'],
		'options' => $currentProvider['options'],
	],
]);

// Spread out markers across Europe
$this->Leaflet->addMarker(['lat' => 48.8566, 'lng' => 2.3522, 'title' => 'Paris', 'content' => 'Paris, France']);
$this->Leaflet->addMarker(['lat' => 52.5200, 'lng' => 13.4050, 'title' => 'Berlin', 'content' => 'Berlin, Germany']);
$this->Leaflet->addMarker(['lat' => 41.9028, 'lng' => 12.4964, 'title' => 'Rome', 'content' => 'Rome, Italy']);
$this->Leaflet->addMarker(['lat' => 40.4168, 'lng' => -3.7038, 'title' => 'Madrid', 'content' => 'Madrid, Spain']);
$this->Leaflet->finalize();
?>

<h4>Map with GeoJSON</h4>
<p>Load geographic data using GeoJSON format:</p>
<?php
echo $this->Leaflet->map([
	'zoom' => 5,
	'lat' => 48.0,
	'lng' => 10.0,
	'div' => ['id' => 'leaflet-map-geojson', 'height' => '300px'],
	'tileLayer' => [
		'url' => $currentProvider['url'],
		'options' => $currentProvider['options'],
	],
]);

// Sample GeoJSON data - a LineString representing a route
$geoJsonData = [
	'type' => 'FeatureCollection',
	'features' => [
		[
			'type' => 'Feature',
			'geometry' => [
				'type' => 'LineString',
				'coordinates' => [
					[11.5820, 48.1351], // Munich
					[11.4041, 47.2692], // Innsbruck
					[11.3548, 46.4983], // Bolzano
					[11.8768, 45.4064], // Verona
				],
			],
			'properties' => ['name' => 'Alpine Route'],
		],
		[
			'type' => 'Feature',
			'geometry' => [
				'type' => 'Point',
				'coordinates' => [11.5820, 48.1351],
			],
			'properties' => ['name' => 'Munich'],
		],
		[
			'type' => 'Feature',
			'geometry' => [
				'type' => 'Point',
				'coordinates' => [11.8768, 45.4064],
			],
			'properties' => ['name' => 'Verona'],
		],
	],
];

$this->Leaflet->addGeoJson($geoJsonData, [
	'style' => [
		'color' => '#ff7800',
		'weight' => 4,
		'opacity' => 0.8,
	],
]);
$this->Leaflet->finalize();
?>

<h4>Map with Marker Clustering</h4>
<p>Group nearby markers into clusters using <code>enableClustering()</code>. Click clusters to expand:</p>
<?php
echo $this->Leaflet->map([
	'zoom' => 5,
	'lat' => 48.0,
	'lng' => 10.0,
	'div' => ['id' => 'leaflet-map-cluster', 'height' => '350px'],
	'tileLayer' => [
		'url' => $currentProvider['url'],
		'options' => $currentProvider['options'],
	],
]);

// Enable clustering before adding markers
$this->Leaflet->enableClustering([
	'showCoverageOnHover' => false,
	'maxClusterRadius' => 50,
]);

// Add many markers - they will be grouped into clusters
$cities = [
	// Germany
	['lat' => 52.5200, 'lng' => 13.4050, 'title' => 'Berlin'],
	['lat' => 48.1351, 'lng' => 11.5820, 'title' => 'Munich'],
	['lat' => 50.1109, 'lng' => 8.6821, 'title' => 'Frankfurt'],
	['lat' => 53.5511, 'lng' => 9.9937, 'title' => 'Hamburg'],
	['lat' => 50.9375, 'lng' => 6.9603, 'title' => 'Cologne'],
	['lat' => 51.2277, 'lng' => 6.7735, 'title' => 'Düsseldorf'],
	['lat' => 48.7758, 'lng' => 9.1829, 'title' => 'Stuttgart'],
	// Austria
	['lat' => 48.2082, 'lng' => 16.3738, 'title' => 'Vienna'],
	['lat' => 47.0707, 'lng' => 15.4395, 'title' => 'Graz'],
	['lat' => 48.3069, 'lng' => 14.2858, 'title' => 'Linz'],
	['lat' => 47.8095, 'lng' => 13.0550, 'title' => 'Salzburg'],
	['lat' => 47.2692, 'lng' => 11.4041, 'title' => 'Innsbruck'],
	// Switzerland
	['lat' => 47.3769, 'lng' => 8.5417, 'title' => 'Zurich'],
	['lat' => 46.9480, 'lng' => 7.4474, 'title' => 'Bern'],
	['lat' => 46.2044, 'lng' => 6.1432, 'title' => 'Geneva'],
	['lat' => 47.5596, 'lng' => 7.5886, 'title' => 'Basel'],
	// France
	['lat' => 48.8566, 'lng' => 2.3522, 'title' => 'Paris'],
	['lat' => 45.7640, 'lng' => 4.8357, 'title' => 'Lyon'],
	['lat' => 43.2965, 'lng' => 5.3698, 'title' => 'Marseille'],
	['lat' => 43.6047, 'lng' => 1.4442, 'title' => 'Toulouse'],
	// Italy
	['lat' => 41.9028, 'lng' => 12.4964, 'title' => 'Rome'],
	['lat' => 45.4642, 'lng' => 9.1900, 'title' => 'Milan'],
	['lat' => 40.8518, 'lng' => 14.2681, 'title' => 'Naples'],
	['lat' => 45.4408, 'lng' => 12.3155, 'title' => 'Venice'],
	['lat' => 43.7696, 'lng' => 11.2558, 'title' => 'Florence'],
];

foreach ($cities as $city) {
	$this->Leaflet->addMarker([
		'lat' => $city['lat'],
		'lng' => $city['lng'],
		'title' => $city['title'],
		'content' => '<b>' . $city['title'] . '</b>',
	]);
}
$this->Leaflet->finalize();
?>
<p class="text-muted"><small>25 European cities grouped into clusters. Zoom in or click clusters to see individual markers.</small></p>

</div></div>
