<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Templating\View\Helper\IconHelper;
use Templating\View\Icon\BootstrapIcon;

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/templating'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>SVG Icons</h2>

	<p>Bootstrap Icons (and potentially other icon sets) can be rendered as inline SVG instead of using icon fonts. This provides better customization, accessibility, and consistent rendering across browsers.</p>

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
		</ul>
	</div>

	<h3>Configuration</h3>
	Configure the SVG path in your <code>app.php</code>:
	<?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'bs' => [
				'class' => \Templating\View\Helper\Icon\BootstrapIcon::class,
				'svgPath' => WWW_ROOT . 'assets/bootstrap-icons/icons/',
			],
		],
	],
TEXT;
		echo $this->Highlighter->highlight($text, ['lang' => 'php']);
		?>

	<p>When <code>svgPath</code> is configured, the icon will be rendered as an inline SVG element loaded from the configured directory.</p>

	<h3>Basic Usage</h3>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('heart-fill'); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<p>
		<?php
		// We hack the loading of this for this template demo, use normal helper loading in your app!
		Configure::write('Icon.sets.bs-svg', [
			'class' => BootstrapIcon::class,
			'svgPath' => WWW_ROOT . 'assets/bootstrap-icons/icons/',
		] + Configure::read('Icon.sets.bs'));
		$this->Icon = new IconHelper($this);

		echo $this->Icon->render('bs-svg:heart-fill');
		?> (rendered as inline SVG)
	</p>

	<h3>Customization Examples</h3>

	<h4>Custom Colors</h4>
	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('heart-fill', [], ['style' => 'fill: #e74c3c; width: 2em; height: 2em;']); ?>
<?php echo \$this->Icon->render('star-fill', [], ['style' => 'fill: #f39c12; width: 2em; height: 2em;']); ?>
<?php echo \$this->Icon->render('shield-fill-check', [], ['style' => 'fill: #27ae60; width: 2em; height: 2em;']); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<p>
		<?php
		echo $this->Icon->render('bs-svg:heart-fill', [], ['style' => 'fill: #e74c3c; width: 2em; height: 2em;']);
		echo ' ';
		echo $this->Icon->render('bs-svg:star-fill', [], ['style' => 'fill: #f39c12; width: 2em; height: 2em;']);
		echo ' ';
		echo $this->Icon->render('bs-svg:shield-fill-check', [], ['style' => 'fill: #27ae60; width: 2em; height: 2em;']);
		?>
	</p>

	<h4>Custom CSS Classes</h4>
	<p>You can add custom CSS classes for advanced styling:</p>

	<style>
		.icon-hover {
			fill: #3498db;
			transition: all 0.3s ease;
			cursor: pointer;
		}
		.icon-hover:hover {
			fill: #e74c3c;
			transform: scale(1.2);
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
	fill: #3498db;
	transition: all 0.3s ease;
	cursor: pointer;
}
.icon-hover:hover {
	fill: #e74c3c;
	transform: scale(1.2);
}

// Template
<?php echo \$this->Icon->render('emoji-smile', [], ['class' => 'icon-hover', 'style' => 'width: 2em; height: 2em;']); ?>
TEXT;
		echo $this->Highlighter->highlight($text, ['lang' => 'php']);
		?>
	</code>

	<p>results in (hover over the icon):</p>

	<p>
		<?php
		echo $this->Icon->render('bs-svg:emoji-smile', [], ['class' => 'icon-hover', 'style' => 'width: 2em; height: 2em;']);
		?>
	</p>

	<h4>Animated Icons</h4>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('arrow-clockwise', [], ['class' => 'icon-pulse', 'style' => 'fill: #9b59b6; width: 2em; height: 2em;']); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<p>
		<?php
		echo $this->Icon->render('bs-svg:arrow-clockwise', [], ['class' => 'icon-pulse', 'style' => 'fill: #9b59b6; width: 2em; height: 2em;']);
		?>
	</p>

	<h4>Accessibility</h4>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Icon->render('info-circle-fill', [], [
	'role' => 'img',
	'aria-label' => 'Information icon',
	'style' => 'fill: #3498db; width: 1.5em; height: 1.5em;',
]); ?>
TEXT;
		echo nl2br(h($text));
		?>
	</code>

	<p>results in:</p>

	<p>
		<?php
		echo $this->Icon->render('bs-svg:info-circle-fill', [], [
			'role' => 'img',
			'aria-label' => 'Information icon',
			'style' => 'fill: #3498db; width: 1.5em; height: 1.5em;',
		]);
		?>
		<span style="margin-left: 0.5em;">Information with accessible icon</span>
	</p>

	<h3>Performance: Caching</h3>

	<p>The Templating plugin includes built-in caching for SVG icons to improve performance:</p>

	<?php
		$text = <<<TEXT
	'Icon' => [
		'sets' => [
			'bs' => [
				'class' => \Templating\View\Helper\Icon\BootstrapIcon::class,
				'svgPath' => WWW_ROOT . 'assets/bootstrap-icons/icons/',
				'cache' => 'default', // Use CakePHP cache
			],
		],
	],
TEXT;
		echo $this->Highlighter->highlight($text, ['lang' => 'php']);
		?>

	<p>This caches the SVG content, reducing file I/O operations for frequently used icons.</p>

	<h3>More Examples</h3>

	<div class="row">
		<div class="col-md-12">
			<p>Various Bootstrap icons rendered as SVG with custom styling:</p>
			<p style="font-size: 2em; display: flex; gap: 1em; flex-wrap: wrap;">
				<?php
				$icons = [
					['name' => 'cart-fill', 'color' => '#e74c3c'],
					['name' => 'bell-fill', 'color' => '#f39c12'],
					['name' => 'chat-fill', 'color' => '#3498db'],
					['name' => 'gear-fill', 'color' => '#95a5a6'],
					['name' => 'house-fill', 'color' => '#16a085'],
					['name' => 'person-fill', 'color' => '#8e44ad'],
					['name' => 'envelope-fill', 'color' => '#c0392b'],
					['name' => 'calendar-fill', 'color' => '#27ae60'],
				];

				foreach ($icons as $icon) {
					echo $this->Icon->render('bs-svg:' . $icon['name'], [], [
						'style' => 'fill: ' . $icon['color'] . '; width: 1em; height: 1em;',
						'title' => $icon['name'],
					]);
				}
				?>
			</p>
		</div>
	</div>

	<div class="float-right">
		<p>
			<?php echo $this->Html->link('Show all icons', ['action' => 'iconSets', 'bs']); ?>
		</p>
	</div>

</div>
