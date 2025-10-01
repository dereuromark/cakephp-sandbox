<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entity $category
 * @var array $tags
 */

$this->loadHelper('Tags.Tag');
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tags'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Tags with Colors</h3>

<p>
	The Tags plugin now supports colors! You can assign hex color codes to tags and display them with custom styling.
</p>

<h4>Example: Displaying colored tags using helper methods</h4>

<div class="mb-4">
	<h5>Using <code>$this->Tag->tags()</code>:</h5>
	<?= $this->Tag->tags($tags) ?>
</div>

<div class="mb-4">
	<h5>Using <code>$this->Tag->badges()</code>:</h5>
	<?= $this->Tag->badges($tags) ?>
</div>

<div class="mb-4">
	<h5>Using <code>$this->Tag->pills()</code>:</h5>
	<?= $this->Tag->pills($tags) ?>
</div>

<div class="mb-4">
	<h5>Individual tags with <code>$this->Tag->tag()</code>:</h5>
	<?php foreach ($tags as $tag) { ?>
		<?= $this->Tag->tag($tag) ?>
	<?php } ?>
</div>

<div class="mb-4">
	<h5>Tags with custom styling:</h5>
	<?php foreach ($tags as $tag) { ?>
		<?= $this->Tag->tag($tag, [
			'class' => 'tag-custom',
			'style' => [
				'font-size' => '1.1em',
				'padding' => '6px 16px',
				'font-weight' => 'bold',
				'border-radius' => '8px',
			],
		]) ?>
	<?php } ?>
</div>

<div class="mb-4">
	<h5>Tags with hover effect (using <code>adjustBrightness()</code>):</h5>
	<style>
		.tag-hover {
			transition: all 0.2s ease;
		}
		<?php foreach ($tags as $index => $tag) {
			$color = $tag['color'] ?? '#cccccc';
			$hoverColor = $this->Tag->adjustBrightness($color, -15);
			echo ".tag-hover-{$index}:hover { background-color: {$hoverColor} !important; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }\n";
		} ?>
	</style>
	<?php foreach ($tags as $index => $tag) { ?>
		<?= $this->Tag->tag($tag, [
			'class' => "tag-hover tag-hover-{$index}",
		]) ?>
	<?php } ?>
</div>

<div class="mb-4">
	<h5>Using <code>$this->Tag->list()</code> with links:</h5>
	<?= $this->Tag->list($tags, [
		'url' => ['controller' => 'Tags', 'action' => 'search', '?'],
		'separator' => ' ',
	]) ?>
</div>

<div class="mb-4">
	<h5>Using <code>getContrastColor()</code> demonstration:</h5>
	<div class="table-responsive">
		<table class="table table-sm">
			<thead>
				<tr>
					<th>Tag</th>
					<th>Background Color</th>
					<th>Calculated Text Color</th>
					<th>Brightness</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($tags as $tag) {
					$bgColor = $tag['color'] ?? '#cccccc';
					$textColor = $this->Tag->getContrastColor($bgColor);
					$rgb = \Tags\Utility\ColorUtility::hexToRgb($bgColor);
					$brightness = (($rgb['r'] * 299) + ($rgb['g'] * 587) + ($rgb['b'] * 114)) / 1000;
				?>
					<tr>
						<td><?= $this->Tag->tag($tag) ?></td>
						<td><code><?= h($bgColor) ?></code></td>
						<td><code><?= h($textColor) ?></code></td>
						<td><?= number_format($brightness, 2) ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<h4>Adding tags with color input in forms</h4>
<p>
	When creating or editing tags, you can now include a color picker input:
</p>

<?php
echo $this->Form->create($category);
echo $this->Form->control('title');
echo $this->Tag->control(['help' => 'Use comma (,) for separation.']);
echo '<div class="alert alert-info mt-3">';
echo '<strong>Note:</strong> To add colors to tags, edit the tag directly in the Tags table with a color field (hex format like #FF5733).';
echo '</div>';
echo $this->Form->submit('Save');

echo $this->Form->end();
?>

<h4>Code Examples - TagHelper Methods</h4>
<p>Display tags with colors using the new helper methods:</p>

<div class="row">
	<div class="col-md-6">
		<h5>Basic Rendering</h5>
<pre><code>// Simple wrapper with all tags
echo $this-&gt;Tag-&gt;tags($entity-&gt;tags);

// No wrapper
echo $this-&gt;Tag-&gt;tags($entity-&gt;tags, [
    'wrapper' => false,
]);

// Custom wrapper
echo $this-&gt;Tag-&gt;tags($entity-&gt;tags, [
    'wrapper' => 'span',
    'wrapperClass' => 'my-tags',
]);
</code></pre>

		<h5>Bootstrap Styles</h5>
<pre><code>// Bootstrap badges
echo $this-&gt;Tag-&gt;badges($entity-&gt;tags);

// Rounded pills
echo $this-&gt;Tag-&gt;pills($entity-&gt;tags);
</code></pre>
	</div>

	<div class="col-md-6">
		<h5>Single Tag</h5>
<pre><code>// Basic single tag
echo $this-&gt;Tag-&gt;tag($tag);

// With custom options
echo $this-&gt;Tag-&gt;tag($tag, [
    'class' => 'my-tag',
    'style' => [
        'font-size' => '1.2em',
        'padding' => '8px 16px',
    ],
]);

// Tag as link
echo $this-&gt;Tag-&gt;tag($tag, [
    'url' => [
        'controller' => 'Posts',
        'action' => 'tagged',
        $tag['slug'],
    ],
]);
</code></pre>

		<h5>Tag List</h5>
<pre><code>// Tags with links
echo $this-&gt;Tag-&gt;list($entity-&gt;tags, [
    'url' => [
        'controller' => 'Posts',
        'action' => 'tagged',
    ],
]);

// Custom separator
echo $this-&gt;Tag-&gt;list($entity-&gt;tags, [
    'separator' => ' | ',
]);
</code></pre>
	</div>
</div>

<h5>Color Utilities in Views</h5>
<pre><code>// Get contrast color (black or white for readability)
$textColor = $this-&gt;Tag-&gt;getContrastColor('#FF5733');

// Adjust brightness for hover effects
$lighterColor = $this-&gt;Tag-&gt;adjustBrightness('#FF5733', 20);
$darkerColor = $this-&gt;Tag-&gt;adjustBrightness('#FF5733', -20);

// Example with dynamic hover colors
foreach ($tags as $index => $tag) {
    $hoverColor = $this-&gt;Tag-&gt;adjustBrightness($tag['color'], -15);
    echo "&lt;style&gt;.tag-{$index}:hover { background: {$hoverColor}; }&lt;/style&gt;";
    echo $this-&gt;Tag-&gt;tag($tag, ['class' =&gt; "tag-{$index}"]);
}
</code></pre>

<h4>ColorUtility Class</h4>
<p>For validation and utility functions, use the <code>ColorUtility</code> class (server-side):</p>

<div class="row">
	<div class="col-md-6">
		<h5>Validation</h5>
<pre><code>use Tags\Utility\ColorUtility;

// Validate hex color format
if (ColorUtility::isValidHex('#FF5733')) {
    // Valid: has # and 6 hex digits
}

// Returns false for invalid formats
ColorUtility::isValidHex('FF5733');    // false (no #)
ColorUtility::isValidHex('#FFF');      // false (too short)
ColorUtility::isValidHex('#GGGGGG');   // false (invalid chars)
</code></pre>

		<h5>Normalization</h5>
<pre><code>// Normalize to uppercase with #
$color = ColorUtility::normalize('ff5733');
// Returns: '#FF5733'

$color = ColorUtility::normalize('#abc123');
// Returns: '#ABC123'
</code></pre>
	</div>

	<div class="col-md-6">
		<h5>Color Generation</h5>
<pre><code>// Generate random hex color
$randomColor = ColorUtility::random();
// Returns: e.g., '#A3B2C1'

// Use in tag creation
$tag->color = ColorUtility::random();
</code></pre>

		<h5>Conversion</h5>
<pre><code>// Hex to RGB array
$rgb = ColorUtility::hexToRgb('#FF5733');
// Returns: ['r' => 255, 'g' => 87, 'b' => 51]

// RGB to Hex
$hex = ColorUtility::rgbToHex(255, 87, 51);
// Returns: '#FF5733'

// Example: Calculate brightness
$rgb = ColorUtility::hexToRgb('#FF5733');
$brightness = (
    ($rgb['r'] * 299) +
    ($rgb['g'] * 587) +
    ($rgb['b'] * 114)
) / 1000;
</code></pre>
	</div>
</div>

<h5>Practical Examples</h5>
<pre><code>use Tags\Utility\ColorUtility;

// In a controller - validate user input
public function edit($id)
{
    $tag = $this->Tags->get($id);
    if ($this->request->is(['post', 'put'])) {
        $data = $this->request->getData();
        if (isset($data['color']) && !ColorUtility::isValidHex($data['color'])) {
            $this->Flash->error('Invalid color format. Use hex format like #FF5733');
            return;
        }
        $tag = $this->Tags->patchEntity($tag, $data);
        // ... save
    }
}

// In a table - generate random colors for new tags
public function beforeSave($event, $entity)
{
    if ($entity->isNew() && empty($entity->color)) {
        $entity->color = ColorUtility::random();
    }
}
</code></pre>

</div>
