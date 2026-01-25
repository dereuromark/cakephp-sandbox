<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array<string, mixed>> $providers
 * @var array<string, array<string, mixed>> $configuredProviders
 * @var string|null $provider
 * @var string|null $style
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/geo'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Static Maps</h2>

<p>
	The StaticMapHelper generates static map images from various providers without requiring JavaScript.
	It supports multiple providers with a unified API.
</p>

<h3>Supported Providers</h3>

<table class="table table-bordered table-sm">
	<thead>
		<tr>
			<th>Provider</th>
			<th>Styles</th>
			<th>API Key Required</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($providers as $key => $providerInfo) { ?>
		<tr>
			<td><?= h($providerInfo['name']) ?></td>
			<td><code><?= h(implode(', ', $providerInfo['styles'])) ?></code></td>
			<td>Yes</td>
			<td>
				<?php if (isset($configuredProviders[$key])) { ?>
					<span class="badge bg-success">Configured</span>
				<?php } else { ?>
					<span class="badge bg-secondary">Not configured</span>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php if (empty($configuredProviders)) { ?>
	<div class="alert alert-info">
		<h4>Configuration Required</h4>
		<p>No static map providers are configured. Add API keys to <code>config/app_local.php</code>:</p>
		<pre><code>'StaticMap' => [
    'provider' => 'geoapify',
    'geoapify' => [
        'apiKey' => env('GEOAPIFY_API_KEY'),
    ],
    'mapbox' => [
        'apiKey' => env('MAPBOX_ACCESS_TOKEN'),
    ],
    'stadia' => [
        'apiKey' => env('STADIA_API_KEY'),
    ],
    'google' => [
        'apiKey' => env('GOOGLE_MAPS_API_KEY'),
    ],
],</code></pre>
		<p><strong>Note:</strong> For Google, the existing <code>GoogleMap.key</code> config is used as fallback if <code>StaticMap.google.apiKey</code> is not set.</p>
	</div>
<?php } else { ?>

<h3>Provider Selection</h3>

<form method="get" class="mb-4">
	<div class="row g-3 align-items-end">
		<div class="col-auto">
			<label for="provider" class="form-label">Provider</label>
			<select name="provider" id="provider" class="form-select" onchange="this.form.submit()">
				<?php foreach ($configuredProviders as $key => $providerInfo) { ?>
					<option value="<?= h($key) ?>" <?= $provider === $key ? 'selected' : '' ?>><?= h($providerInfo['name']) ?></option>
				<?php } ?>
			</select>
		</div>
		<?php if ($provider && isset($configuredProviders[$provider])) { ?>
		<div class="col-auto">
			<label for="style" class="form-label">Style</label>
			<select name="style" id="style" class="form-select" onchange="this.form.submit()">
				<option value="">Default</option>
				<?php foreach ($configuredProviders[$provider]['styles'] as $styleName) { ?>
					<option value="<?= h($styleName) ?>" <?= $style === $styleName ? 'selected' : '' ?>><?= h($styleName) ?></option>
				<?php } ?>
			</select>
		</div>
		<?php } ?>
	</div>
</form>

<?php if ($provider) { ?>

<h3>Basic Map</h3>

<p>Display a static map image centered on Vienna:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$options = [
			'provider' => $provider,
			'lat' => 48.2082,
			'lng' => 16.3738,
			'zoom' => 12,
			'size' => '400x300',
		];
		if ($style) {
			$options['style'] = $style;
		}
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Map of Vienna']);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>echo $this->StaticMap->image([
    'provider' => '<?= h($provider) ?>',
    'lat' => 48.2082,
    'lng' => 16.3738,
    'zoom' => 12,
    'size' => '400x300',
<?php if ($style) { ?>    'style' => '<?= h($style) ?>',
<?php } ?>]);</code></pre>
	</div>
</div>

<hr class="my-4">

<h3>Map with Markers</h3>

<p>Add markers to the map:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$options = [
			'provider' => $provider,
			'lat' => 48.2082,
			'lng' => 16.3738,
			'zoom' => 13,
			'size' => '400x300',
			'markers' => [
				[
					'lat' => 48.2082,
					'lng' => 16.3738,
					'color' => 'red',
				],
				[
					'lat' => 48.1951,
					'lng' => 16.3715,
					'color' => 'blue',
				],
			],
		];
		if ($style) {
			$options['style'] = $style;
		}
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Map with markers']);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>echo $this->StaticMap->image([
    'provider' => '<?= h($provider) ?>',
    'lat' => 48.2082,
    'lng' => 16.3738,
    'zoom' => 13,
    'markers' => [
        ['lat' => 48.2082, 'lng' => 16.3738, 'color' => 'red'],
        ['lat' => 48.1951, 'lng' => 16.3715, 'color' => 'blue'],
    ],
]);</code></pre>
	</div>
</div>

<hr class="my-4">

<h3>Map with Path</h3>

<p>Draw a path between points:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$options = [
			'provider' => $provider,
			'lat' => 47.5,
			'lng' => 15.5,
			'zoom' => 7,
			'size' => '400x300',
			'paths' => [
				[
					'points' => [
						['lat' => 48.2082, 'lng' => 16.3738],
						['lat' => 47.0707, 'lng' => 15.4395],
						['lat' => 46.0569, 'lng' => 14.5058],
					],
					'color' => 'blue',
					'weight' => 3,
				],
			],
		];
		if ($style) {
			$options['style'] = $style;
		}
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Map with path']);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>echo $this->StaticMap->image([
    'provider' => '<?= h($provider) ?>',
    'lat' => 47.5,
    'lng' => 15.5,
    'zoom' => 7,
    'paths' => [
        [
            'points' => [
                ['lat' => 48.2082, 'lng' => 16.3738], // Vienna
                ['lat' => 47.0707, 'lng' => 15.4395], // Graz
                ['lat' => 46.0569, 'lng' => 14.5058], // Ljubljana
            ],
            'color' => 'blue',
            'weight' => 3,
        ],
    ],
]);</code></pre>
	</div>
</div>

<hr class="my-4">

<h3>Retina/HiDPI Images</h3>

<p>Use scale 2 for high-resolution displays:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$options = [
			'provider' => $provider,
			'lat' => 48.2082,
			'lng' => 16.3738,
			'zoom' => 14,
			'size' => '200x150',
			'scale' => 2,
		];
		if ($style) {
			$options['style'] = $style;
		}
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Retina map', 'width' => 200, 'height' => 150]);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>echo $this->StaticMap->image([
    'provider' => '<?= h($provider) ?>',
    'lat' => 48.2082,
    'lng' => 16.3738,
    'zoom' => 14,
    'size' => '200x150',
    'scale' => 2,
], ['width' => 200, 'height' => 150]);</code></pre>
	</div>
</div>

<hr class="my-4">

<h3>Get URL Only</h3>

<p>Get just the URL without the img tag:</p>

<div class="row">
	<div class="col-md-12">
		<?php
		$options = [
			'provider' => $provider,
			'lat' => 48.2082,
			'lng' => 16.3738,
			'zoom' => 12,
		];
		if ($style) {
			$options['style'] = $style;
		}
		$url = $this->StaticMap->url($options);
		?>
		<pre><code><?= h($url) ?></code></pre>
		<h5>Code</h5>
		<pre><code>$url = $this->StaticMap->url([
    'provider' => '<?= h($provider) ?>',
    'lat' => 48.2082,
    'lng' => 16.3738,
    'zoom' => 12,
]);</code></pre>
	</div>
</div>

<hr class="my-4">

<h3>Filled Polygon</h3>

<p>Draw a filled polygon by closing the path and adding a fill color:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$options = [
			'provider' => $provider,
			'lat' => 48.21,
			'lng' => 16.37,
			'zoom' => 14,
			'size' => '400x300',
			'paths' => [
				[
					'points' => [
						['lat' => 48.2082, 'lng' => 16.3738],
						['lat' => 48.2150, 'lng' => 16.3600],
						['lat' => 48.2200, 'lng' => 16.3800],
						['lat' => 48.2082, 'lng' => 16.3738],
					],
					'color' => 'blue',
					'weight' => 2,
					'fillColor' => 'yellow',
				],
			],
		];
		if ($style) {
			$options['style'] = $style;
		}
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Filled polygon']);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>echo $this->StaticMap->image([
    'provider' => '<?= h($provider) ?>',
    'lat' => 48.21,
    'lng' => 16.37,
    'zoom' => 14,
    'paths' => [
        [
            'points' => [
                ['lat' => 48.2082, 'lng' => 16.3738],
                ['lat' => 48.2150, 'lng' => 16.3600],
                ['lat' => 48.2200, 'lng' => 16.3800],
                ['lat' => 48.2082, 'lng' => 16.3738], // Close polygon
            ],
            'color' => 'blue',
            'weight' => 2,
            'fillColor' => 'yellow',
        ],
    ],
]);</code></pre>
	</div>
</div>

<hr class="my-4">

<h3>Multiple Markers with Helper</h3>

<p>Use the <code>markers()</code> helper to format multiple positions with consistent styling:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$positions = [
			['lat' => 48.2082, 'lng' => 16.3738],
			['lat' => 48.1951, 'lng' => 16.3715],
			['lat' => 48.2100, 'lng' => 16.3500],
			['lat' => 48.2000, 'lng' => 16.3900],
		];
		$markers = $this->StaticMap->markers($positions, [
			'color' => 'purple',
		]);
		$options = [
			'provider' => $provider,
			'lat' => 48.205,
			'lng' => 16.37,
			'zoom' => 14,
			'size' => '400x300',
			'markers' => $markers,
		];
		if ($style) {
			$options['style'] = $style;
		}
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Multiple markers']);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>$positions = [
    ['lat' => 48.2082, 'lng' => 16.3738],
    ['lat' => 48.1951, 'lng' => 16.3715],
    ['lat' => 48.2100, 'lng' => 16.3500],
    ['lat' => 48.2000, 'lng' => 16.3900],
];

$markers = $this->StaticMap->markers($positions, [
    'color' => 'purple',
]);

echo $this->StaticMap->image([
    'provider' => '<?= h($provider) ?>',
    'markers' => $markers,
]);</code></pre>
	</div>
</div>

<?php if ($provider === 'google') { ?>
<hr class="my-4">

<h3>Labeled Markers (Google)</h3>

<p>Use <code>autoLabel</code> to add A, B, C labels to markers:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$positions = [
			['lat' => 48.2082, 'lng' => 16.3738],
			['lat' => 48.1951, 'lng' => 16.3715],
			['lat' => 48.2100, 'lng' => 16.3500],
		];
		$markers = $this->StaticMap->markers($positions, [
			'color' => 'green',
			'autoLabel' => true,
		]);
		$options = [
			'provider' => 'google',
			'lat' => 48.205,
			'lng' => 16.37,
			'zoom' => 14,
			'size' => '400x300',
			'markers' => $markers,
		];
		if ($style) {
			$options['style'] = $style;
		}
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Labeled markers']);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>$markers = $this->StaticMap->markers($positions, [
    'color' => 'green',
    'autoLabel' => true, // Adds A, B, C...
]);

echo $this->StaticMap->image([
    'provider' => 'google',
    'markers' => $markers,
]);</code></pre>
	</div>
</div>

<hr class="my-4">

<h3>Custom Marker Icon (Google)</h3>

<p>Google supports custom marker icons via URL:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$options = [
			'provider' => 'google',
			'lat' => 48.2082,
			'lng' => 16.3738,
			'zoom' => 14,
			'size' => '400x300',
			'markers' => [
				[
					'lat' => 48.2082,
					'lng' => 16.3738,
					'icon' => 'https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png',
				],
			],
		];
		if ($style) {
			$options['style'] = $style;
		}
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Custom icon marker']);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>echo $this->StaticMap->image([
    'provider' => 'google',
    'lat' => 48.2082,
    'lng' => 16.3738,
    'zoom' => 14,
    'markers' => [
        [
            'lat' => 48.2082,
            'lng' => 16.3738,
            'icon' => 'https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png',
        ],
    ],
]);</code></pre>
		<p class="text-muted mt-2"><small>Google provides many <a href="https://sites.google.com/site/gmapsdevelopment/polern/google-kml-icons-702702" target="_blank">built-in KML icons</a>.</small></p>
	</div>
</div>
<?php } ?>

<?php if ($provider === 'geoapify') { ?>
<hr class="my-4">

<h3>Many Style Options (Geoapify)</h3>

<p>Geoapify offers many map styles including dark themes:</p>

<div class="row">
	<div class="col-md-6">
		<?php
		$options = [
			'provider' => 'geoapify',
			'lat' => 48.2082,
			'lng' => 16.3738,
			'zoom' => 13,
			'size' => '400x300',
			'style' => 'dark-matter',
			'markers' => [
				[
					'lat' => 48.2082,
					'lng' => 16.3738,
					'color' => 'orange',
				],
			],
		];
		echo $this->StaticMap->image($options, ['class' => 'img-fluid border', 'alt' => 'Geoapify dark theme']);
		?>
	</div>
	<div class="col-md-6">
		<h5>Code</h5>
		<pre><code>echo $this->StaticMap->image([
    'provider' => 'geoapify',
    'lat' => 48.2082,
    'lng' => 16.3738,
    'zoom' => 13,
    'style' => 'dark-matter',
    'markers' => [
        ['lat' => 48.2082, 'lng' => 16.3738, 'color' => 'orange'],
    ],
]);</code></pre>
		<p class="text-muted mt-2"><small>Available styles: osm-bright, dark-matter, positron, toner, and <a href="https://apidocs.geoapify.com/docs/maps/static/" target="_blank">more</a>.</small></p>
	</div>
</div>
<?php } ?>

<?php } ?>

<?php } ?>

<hr class="my-4">

<h3>Helper Methods</h3>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Method</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><code>image($options, $attributes)</code></td>
			<td>Returns an img tag with the static map</td>
		</tr>
		<tr>
			<td><code>url($options)</code></td>
			<td>Returns just the URL to the static map image</td>
		</tr>
		<tr>
			<td><code>link($title, $options, $attributes)</code></td>
			<td>Returns a link wrapping the static map image</td>
		</tr>
		<tr>
			<td><code>markers($positions, $options)</code></td>
			<td>Helper to format marker arrays with styling and auto-labels</td>
		</tr>
		<tr>
			<td><code>paths($pathData, $options)</code></td>
			<td>Helper to format path arrays with default styling</td>
		</tr>
		<tr>
			<td><code>supportedStyles($provider)</code></td>
			<td>Get list of supported styles for a provider</td>
		</tr>
		<tr>
			<td><code>availableProviders()</code></td>
			<td>Get list of available provider names</td>
		</tr>
	</tbody>
</table>

</div></div>
