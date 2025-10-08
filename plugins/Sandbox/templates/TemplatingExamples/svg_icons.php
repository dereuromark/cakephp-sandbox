<?php
/**
 * @var \App\View\AppView $this
 */


?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/templating'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>SVG Icons</h2>

	<p>Icon sets can be rendered as inline SVG instead of using icon fonts or data attributes. This provides better customization, accessibility, and consistent rendering across browsers.</p>

	<h3>Why SVG is Better Than Classic Font Icons</h3>

	<div class="alert alert-info">
		<h4>Advantages of SVG Icons:</h4>
		<ul>
			<li><strong>More Consistent Rendering:</strong> SVG icons render identically across all devices and browsers, without anti-aliasing issues that can affect font icons</li>
			<li><strong>Greater Customization:</strong> You can style individual parts of an SVG icon, apply gradients, and use CSS transformations more effectively</li>
			<li><strong>Better Accessibility:</strong> SVG icons can include proper ARIA labels and descriptions, making them more accessible to screen readers</li>
			<li><strong>No Font Loading Required:</strong> SVG icons don't require loading separate font files, reducing HTTP requests and potential FOUT (Flash of Unstyled Text)</li>
			<li><strong>Scalability:</strong> True vector graphics that scale perfectly at any size without pixelation</li>
			<li><strong>CSS Styling:</strong> Can be styled with CSS properties like <code>fill</code>, <code>stroke</code>, and <code>currentColor</code> for dynamic theming</li>
			<li><strong>Multi-color Support:</strong> Unlike icon fonts, SVG can display multiple colors in a single icon</li>
		</ul>
	</div>

	<h3>Configuration: JSON Map Mode (Recommended)</h3>

	<p>The <strong>recommended approach</strong> is to use JSON map mode, where all icon definitions are loaded from a single JSON file. This provides the best performance.</p>

	<div class="alert alert-success">
		<strong>JSON Map Benefits:</strong> Single file load, no per-icon I/O, better performance, automatically cached in memory
	</div>

	<p>Configure Feather icons with JSON map in your <code>app.php</code>:</p>
	<?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'feather' => [
				'class' => \Templating\View\Icon\FeatherIcon::class,
				'svgPath' => WWW_ROOT . 'assets/feather-icons/dist/icons.json',
			],
		],
	],
TEXT;
		echo $this->Highlighter->highlight($text, ['lang' => 'php']);
		?>

	<p>When <code>svgPath</code> ends with <code>.json</code>, the plugin automatically uses JSON map mode.</p>

	<h3>Alternative: Individual Files Mode</h3>

	<p>You can also load icons from individual SVG files (useful for development or when using only a few icons):</p>

	<?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'bs' => [
				'class' => \Templating\View\Helper\Icon\BootstrapIcon::class,
				'svgPath' => WWW_ROOT . 'assets/bootstrap-icons/icons/', // directory path
				'cache' => 'default', // Recommended when using individual files
			],
		],
	],
TEXT;
		echo $this->Highlighter->highlight($text, ['lang' => 'php']);
		?>

	<h3>Basic Usage (JSON Map Mode)</h3>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('heart'); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<p>
		<?php
		echo $this->Icon->render('feather:heart');
		?> (rendered as inline SVG from JSON map)
	</p>

	<h3>Customization Examples</h3>

	<h4>Custom Colors and Stroke</h4>
	<p>Feather icons use strokes, which can be customized with CSS:</p>
	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('heart', [], ['style' => 'stroke: #e74c3c; width: 2em; height: 2em;']); ?>
<?php echo \$this->Icon->render('star', [], ['style' => 'stroke: #f39c12; fill: #f39c12; width: 2em; height: 2em;']); ?>
<?php echo \$this->Icon->render('shield', [], ['style' => 'stroke: #27ae60; width: 2em; height: 2em;']); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<p>
		<?php
		echo $this->Icon->render('feather:heart', [], ['style' => 'stroke: #e74c3c; width: 2em; height: 2em;']);
		echo ' ';
		echo $this->Icon->render('feather:star', [], ['style' => 'stroke: #f39c12; fill: #f39c12; width: 2em; height: 2em;']);
		echo ' ';
		echo $this->Icon->render('feather:shield', [], ['style' => 'stroke: #27ae60; width: 2em; height: 2em;']);
		?>
	</p>

	<h4>Custom CSS Classes</h4>
	<p>You can add custom CSS classes for advanced styling:</p>

	<style>
		.icon-hover {
			stroke: #3498db;
			transition: all 0.3s ease;
			cursor: pointer;
		}
		.icon-hover:hover {
			stroke: #e74c3c;
			transform: scale(1.2) rotate(15deg);
		}
		.icon-pulse {
			animation: pulse 2s infinite;
		}
		@keyframes pulse {
			0%, 100% { opacity: 1; }
			50% { opacity: 0.5; }
		}
	</style>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
// CSS
.icon-hover {
	stroke: #3498db;
	transition: all 0.3s ease;
	cursor: pointer;
}
.icon-hover:hover {
	stroke: #e74c3c;
	transform: scale(1.2) rotate(15deg);
}

// Template
<?php echo \$this->Icon->render('smile', [], ['class' => 'icon-hover', 'style' => 'width: 2em; height: 2em;']); ?>
TEXT;
		echo $this->Highlighter->highlight($text, ['lang' => 'php']);
		?>
	</code>

	<p>results in (hover over the icon):</p>

	<p>
		<?php
		echo $this->Icon->render('feather:smile', [], ['class' => 'icon-hover', 'style' => 'width: 2em; height: 2em;']);
		?>
	</p>

	<h4>Animated Icons</h4>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('refresh-cw', [], ['class' => 'icon-pulse', 'style' => 'stroke: #9b59b6; width: 2em; height: 2em;']); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<p>
		<?php
		echo $this->Icon->render('feather:refresh-cw', [], ['class' => 'icon-pulse', 'style' => 'stroke: #9b59b6; width: 2em; height: 2em;']);
		?>
	</p>

	<h4>Accessibility</h4>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('info', [], [
	'role' => 'img',
	'aria-label' => 'Information icon',
	'style' => 'stroke: #3498db; width: 1.5em; height: 1.5em;',
]); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<p>
		<?php
		echo $this->Icon->render('feather:info', [], [
			'role' => 'img',
			'aria-label' => 'Information icon',
			'style' => 'stroke: #3498db; width: 1.5em; height: 1.5em;',
		]);
		?>
		<span style="margin-left: 0.5em;">Information with accessible icon</span>
	</p>

	<h3>Performance Comparison</h3>

	<div class="row">
		<div class="col-md-6">
			<div class="alert alert-success">
				<h5>JSON Map Mode</h5>
				<ul>
					<li>✓ Single file read</li>
					<li>✓ All icons loaded at once</li>
					<li>✓ In-memory caching</li>
					<li>✓ No per-icon I/O</li>
					<li>✓ Best for production</li>
				</ul>
			</div>
		</div>
		<div class="col-md-6">
			<div class="alert alert-warning">
				<h5>Individual Files Mode</h5>
				<ul>
					<li>• Separate file per icon</li>
					<li>• File I/O per icon</li>
					<li>• Cache recommended</li>
					<li>• Good for few icons</li>
					<li>• Good for development</li>
				</ul>
			</div>
		</div>
	</div>

	<p>For individual files mode, enable CakePHP caching to reduce file I/O:</p>

	<?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'bs' => [
				'class' => \Templating\View\Helper\Icon\BootstrapIcon::class,
				'svgPath' => WWW_ROOT . 'assets/bootstrap-icons/icons/',
				'cache' => 'default', // Highly recommended for individual files
			],
		],
	],
TEXT;
		echo $this->Highlighter->highlight($text, ['lang' => 'php']);
		?>

	<h3>More Examples (JSON Map Mode)</h3>

	<div class="row">
		<div class="col-md-12">
			<p>Various Feather icons rendered as SVG from JSON map with custom styling:</p>
			<p style="font-size: 2em; display: flex; gap: 1em; flex-wrap: wrap;">
				<?php
				$icons = [
					['name' => 'shopping-cart', 'color' => '#e74c3c'],
					['name' => 'bell', 'color' => '#f39c12'],
					['name' => 'message-circle', 'color' => '#3498db'],
					['name' => 'settings', 'color' => '#95a5a6'],
					['name' => 'home', 'color' => '#16a085'],
					['name' => 'user', 'color' => '#8e44ad'],
					['name' => 'mail', 'color' => '#c0392b'],
					['name' => 'calendar', 'color' => '#27ae60'],
					['name' => 'activity', 'color' => '#2c3e50'],
					['name' => 'database', 'color' => '#34495e'],
					['name' => 'globe', 'color' => '#1abc9c'],
					['name' => 'zap', 'color' => '#f1c40f'],
				];

				foreach ($icons as $icon) {
					echo $this->Icon->render('feather:' . $icon['name'], [], [
						'style' => 'stroke: ' . $icon['color'] . '; width: 1em; height: 1em;',
						'title' => $icon['name'],
					]);
				}
				?>
			</p>
			<p><small><em>All icons loaded from a single JSON file for optimal performance!</em></small></p>
		</div>
	</div>

	<h3>Supported Icon Sets with SVG Mode</h3>

	<div class="row">
		<div class="col-md-12">
			<ul>
				<li><strong>Bootstrap Icons:</strong> 1800+ icons (individual files mode)</li>
				<li><strong>Feather Icons:</strong> 280+ icons (JSON map mode) ✓ Recommended</li>
				<li><strong>Lucide:</strong> 1000+ icons (JSON map mode) - Modern Feather fork</li>
				<li><strong>Heroicons:</strong> 300+ icons (multiple styles)</li>
				<li><strong>FontAwesome:</strong> 2000+ icons (v4/v5/v6)</li>
				<li><strong>Material Icons:</strong> Google's icon set</li>
			</ul>
		</div>
	</div>

	<div class="float-right">
		<p>
			<?php echo $this->Html->link('Show all icon sets', ['action' => 'icons']); ?>
		</p>
	</div>

</div>
