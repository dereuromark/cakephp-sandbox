<?php
/**
 * @var \App\View\AppView $this
 * @var \PhpCollective\DecimalObject\Decimal $price
 * @var \PhpCollective\DecimalObject\Decimal $largePrice
 * @var \PhpCollective\DecimalObject\Decimal $delta
 * @var \PhpCollective\DecimalObject\Decimal $negativeDelta
 * @var \PhpCollective\DecimalObject\Decimal $percentage
 * @var \PhpCollective\DecimalObject\Decimal $smallNumber
 */

use PhpCollective\DecimalObject\Decimal;

?>

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/decimal'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>NumberHelper Integration</h3>
	<p>
		The CakeDecimal plugin extends the NumberHelper to work seamlessly with Decimal value objects.
		This ensures proper precision and scale handling in templates.
	</p>

	<div class="alert alert-info">
		<strong>Setup Required:</strong> Add <code>CakeDecimal.Number</code> in your AppView to enable Decimal support.
		<br>See <a href="https://github.com/dereuromark/cakephp-decimal/blob/master/docs/README.md#templating" target="_blank">documentation</a> for details.
	</div>

	<h4>1. format() - Basic Number Formatting</h4>
	<p>The helper automatically detects the scale from Decimal objects and formats them correctly.</p>

<?php
$code = <<<'PHP'
$price = Decimal::create('1234.56');
echo $this->Number->format($price);
// Output: 1,234.56 (with automatic scale detection)
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

	<div class="card mb-3">
		<div class="card-body">
			<strong>Result:</strong> <?= $this->Number->format($price) ?>
			<br>
			<small class="text-muted">Decimal scale: <?= $price->scale() ?></small>
		</div>
	</div>

	<h4>2. currency() - Currency Formatting</h4>
	<p>Format Decimal objects as currency with proper precision.</p>

<?php
$code = <<<'PHP'
echo $this->Number->currency($price, 'USD');
echo $this->Number->currency($largePrice, 'EUR');
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

	<div class="card mb-3">
		<div class="card-body">
			<strong>USD:</strong> <?= $this->Number->currency($price, 'USD') ?>
			<br>
			<strong>EUR:</strong> <?= $this->Number->currency($largePrice, 'EUR') ?>
			<br>
			<strong>GBP:</strong> <?= $this->Number->currency($price, 'GBP') ?>
		</div>
	</div>

	<h4>3. formatDelta() - Delta/Change Formatting</h4>
	<p>Display positive and negative changes with appropriate formatting and symbols.</p>

<?php
$code = <<<'PHP'
echo $this->Number->formatDelta($delta);        // Positive change
echo $this->Number->formatDelta($negativeDelta); // Negative change
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

	<div class="card mb-3">
		<div class="card-body">
			<strong>Positive:</strong> <?= $this->Number->formatDelta($delta) ?>
			<br>
			<strong>Negative:</strong> <?= $this->Number->formatDelta($negativeDelta) ?>
		</div>
	</div>

	<h4>4. precision() - Custom Precision</h4>
	<p>Override the default scale with custom precision.</p>

<?php
$code = <<<'PHP'
echo $this->Number->precision($price, 3);      // 3 decimal places
echo $this->Number->precision($price, 0);      // No decimals (rounded)
echo $this->Number->precision($smallNumber, 4); // 4 decimal places
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

	<div class="card mb-3">
		<div class="card-body">
			<strong>3 places:</strong> <?= $this->Number->precision($price, 3) ?>
			<br>
			<strong>0 places:</strong> <?= $this->Number->precision($price, 0) ?>
			<br>
			<strong>4 places:</strong> <?= $this->Number->precision($smallNumber, 4) ?>
		</div>
	</div>

	<h4>5. toPercentage() - Percentage Formatting</h4>
	<p>Convert Decimal objects to percentage display.</p>

<?php
$code = <<<'PHP'
echo $this->Number->toPercentage($percentage);
// Note: 0.875 = 87.5%
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

	<div class="card mb-3">
		<div class="card-body">
			<strong>Result:</strong> <?= $this->Number->toPercentage($percentage) ?>
			<br>
			<small class="text-muted">Input value: <?= $percentage ?></small>
		</div>
	</div>

	<h4>Advantages Over Float Casting</h4>
	<div class="card bg-light mb-3">
		<div class="card-body">
			<h5 class="card-title">Why use the extended NumberHelper?</h5>
			<ul>
				<li><strong>Automatic Scale Detection:</strong> The helper uses the Decimal object's internal scale instead of guessing</li>
				<li><strong>Precision Preservation:</strong> No loss of precision from float conversion</li>
				<li><strong>Consistent Output:</strong> Database field scale is maintained throughout the display layer</li>
				<li><strong>Type Safety:</strong> Works with Decimal objects, strings, floats, and integers</li>
			</ul>
		</div>
	</div>

	<h4>Comparison: Decimal vs Float</h4>
	<p>See how the extended NumberHelper maintains precision compared to float casting:</p>

<?php
$code = <<<'PHP'
// With Decimal object
$decimal = Decimal::create('0.10');
echo $this->Number->format($decimal); // 0.10 (scale preserved)

// With float (loses trailing zero)
$float = 0.10;
echo $this->Number->format($float);   // 0.1 (scale lost)
PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<?php
$tenCents = Decimal::create('0.10');
$floatTenCents = 0.10;
?>

	<div class="card mb-3">
		<div class="card-body">
			<strong>Decimal:</strong> <?= $this->Number->format($tenCents) ?>
			<br>
			<strong>Float:</strong> <?= $this->Number->format($floatTenCents) ?>
			<br>
			<small class="text-muted">Notice the Decimal preserves the .10 scale while float becomes .1</small>
		</div>
	</div>

</div></div>
