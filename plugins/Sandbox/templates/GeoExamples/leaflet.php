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
echo $this->Leaflet->map([
	'zoom' => 6,
	'lat' => 48.0,
	'lng' => 11.0,
	'div' => ['id' => 'leaflet-map-polyline', 'height' => '300px'],
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

<h4>Tile Provider Demo</h4>
<p>Switch between different free tile providers:</p>
<div class="mb-3">
	<select id="tile-provider-select" class="form-select" style="max-width: 300px;">
		<option value="osm" selected>OpenStreetMap</option>
		<option value="osm_hot">OpenStreetMap HOT</option>
		<option value="carto_light">CartoDB Positron (Light)</option>
		<option value="carto_dark">CartoDB Dark Matter</option>
		<option value="carto_voyager">CartoDB Voyager</option>
		<option value="opentopomap">OpenTopoMap</option>
		<option value="cyclosm">CyclOSM (Cycling)</option>
		<option value="esri_world">Esri WorldStreetMap</option>
		<option value="esri_satellite">Esri WorldImagery (Satellite)</option>
		<option value="esri_topo">Esri WorldTopoMap</option>
		<option value="stadia_smooth">Stadia Alidade Smooth</option>
		<option value="stadia_dark">Stadia Alidade Smooth Dark</option>
		<option value="stadia_satellite">Stadia Alidade Satellite</option>
	</select>
</div>
<?php
echo $this->Leaflet->map([
	'zoom' => 5,
	'lat' => 48.0,
	'lng' => 11.0,
	'div' => ['id' => 'leaflet-map-providers', 'height' => '400px'],
]);

$this->Leaflet->addMarker([
	'lat' => 48.1351,
	'lng' => 11.5820,
	'title' => 'Munich',
	'content' => 'Munich, Germany',
]);
$this->Leaflet->addMarker([
	'lat' => 47.2692,
	'lng' => 11.4041,
	'title' => 'Innsbruck',
	'content' => 'Innsbruck, Austria',
]);
$this->Leaflet->finalize();
?>

<script>
(function() {
	var providers = {
		osm: {
			url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			options: {
				attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
				maxZoom: 19
			}
		},
		osm_hot: {
			url: 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
			options: {
				attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/">HOT</a>',
				maxZoom: 19
			}
		},
		carto_light: {
			url: 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
			options: {
				attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>',
				subdomains: 'abcd',
				maxZoom: 20
			}
		},
		carto_dark: {
			url: 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
			options: {
				attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>',
				subdomains: 'abcd',
				maxZoom: 20
			}
		},
		carto_voyager: {
			url: 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',
			options: {
				attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>',
				subdomains: 'abcd',
				maxZoom: 20
			}
		},
		opentopomap: {
			url: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
			options: {
				attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | &copy; <a href="https://opentopomap.org">OpenTopoMap</a>',
				maxZoom: 17
			}
		},
		cyclosm: {
			url: 'https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png',
			options: {
				attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, <a href="https://www.cyclosm.org">CyclOSM</a>',
				maxZoom: 20
			}
		},
		esri_world: {
			url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}',
			options: {
				attribution: 'Tiles &copy; Esri',
				maxZoom: 18
			}
		},
		esri_satellite: {
			url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
			options: {
				attribution: 'Tiles &copy; Esri',
				maxZoom: 18
			}
		},
		esri_topo: {
			url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}',
			options: {
				attribution: 'Tiles &copy; Esri',
				maxZoom: 18
			}
		},
		stadia_smooth: {
			url: 'https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png',
			options: {
				attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
				maxZoom: 20
			}
		},
		stadia_dark: {
			url: 'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png',
			options: {
				attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
				maxZoom: 20
			}
		},
		stadia_satellite: {
			url: 'https://tiles.stadiamaps.com/tiles/alidade_satellite/{z}/{x}/{y}{r}.png',
			options: {
				attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; CNES, Distribution Airbus DS, © Airbus DS, © PlanetObserver (Contains Copernicus Data)',
				maxZoom: 20
			}
		}
	};

	var map = map3;
	var currentLayer = L.tileLayer(providers.osm.url, providers.osm.options).addTo(map);

	document.getElementById('tile-provider-select').addEventListener('change', function() {
		var selected = this.value;
		var provider = providers[selected];
		if (provider) {
			map.removeLayer(currentLayer);
			currentLayer = L.tileLayer(provider.url, provider.options).addTo(map);
		}
	});
})();
</script>

</div></div>
