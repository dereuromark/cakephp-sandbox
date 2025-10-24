<?php
/**
 * @var \App\View\AppView $this
 */

use PhpCollective\DecimalObject\Decimal;

?>

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/decimal'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Basic Idea</h3>
	<p>
		Decimals in PHP are essentially float by default. This can come with a few caveats.
		<br>
		See the following example:
	</p>
<?php
$code = <<<PHP
\$decimalOne = 0.10;
\$decimalTwo = 0.20;
\$decimalAdded = \$decimalOne + \$decimalTwo;

PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);

$decimalOne = 0.1;
$decimalTwo = 0.2;
$decimalAdded = $decimalOne + $decimalTwo;
?>

<p>
	<?php echo 'Actual value: ' . '<code>' . var_export($decimalAdded, true) . '</code>';?>
</p>

	<p>Now lets compare that with <code>0.3</code> somewhere:
		<?php
$code = <<<PHP
\$balance = 0.30 - \$decimalAdded;
\$positiveBalance = \$balance >= 0;  // We count 0 as OK

PHP;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>
	<p>
		<?php
		$balance = 0.3 - $decimalAdded;
		$positiveBalance = $balance >= 0;  // We count 0 as OK
		echo 'Positive balance: ' . ($positiveBalance ? 'YES' : 'NO');
		?>
	</p>

		<h3>Value objects</h3>
	<p>
		So in order to have a better handling of those values, using strings is recommended.
		But even strings are not easy to work with often. Using a value object can overcome also those issues and provide
		a clear API.
	</p>

<?php
	$code = <<<PHP
use PhpCollective\DecimalObject\Decimal;

\$decimalOne = Decimal::create('0.10');
\$decimalTwo = Decimal::create('0.20');
\$decimalAdded = \$decimalOne->add(\$decimalTwo);

PHP;
	echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

	<?php
	$decimalOne = Decimal::create('0.10');
	$decimalTwo = Decimal::create('0.20');
	$decimalAdded = $decimalOne->add($decimalTwo);
	?>
	<p>
		<?php echo 'Actual value: ' . '<code>' . h($decimalAdded) . '</code>';?>
	</p>

	<h4>Internal object result</h4>
<?php
echo $this->Highlighter->highlight(print_r($decimalAdded, true), ['lang' => 'php']);
?>
	<p>It also keeps track of the scale and therefore on output will also give the correct (expected) precision/scale for each value if needed.</p>

	<p>Now let's try the founds check again:</p>

	<?php
	$code = <<<PHP
\$balance = Decimal::create('0.30')->subtract(\$decimalAdded);
\$positiveBalance = !\$balance->isNegative(); // We count 0 as OK

PHP;
	echo $this->Highlighter->highlight($code, ['lang' => 'php']);
	?>

	<p>
	<?php
	$balance = Decimal::create('0.30')->subtract($decimalAdded);
	$positiveBalance = !$balance->isNegative(); // We count 0 as OK
	echo 'Positive balance: ' . ($positiveBalance ? 'YES' : 'NO');
	?>
	</p>


	<p>See <a href="https://github.com/php-collective/decimal-object/tree/master/docs" target="_blank">this</a> for basic examples and API details.</p>

</div></div>
