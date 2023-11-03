<?php
/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob[] $queuedJobs
 */
?>

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/decimal'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Basic Idea</h3>
	<p>
		Decimals in PHP are essentially float by default. This can come with a few caveats.
		So in order to have a better handling of those values, using strings is recommended.
		But even strings are not easy to work with often. Using a value object can overcome also those issues and provide
		a clear API.
	</p>

<?php
	$code = <<<PHP
use PhpCollective\DecimalObject\Decimal;

\$decimalOne = Decimal::create('1.1');
\$decimalTwo = Decimal::create('2.2');
\$decimalAdded = \$decimalOne->add(\$decimalTwo);

// Should print `3.3`
echo 'Value: ' . \$decimalAdded;
PHP;
	echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

	<p>See <a href="https://github.com/php-collective/decimal-object/tree/master/docs" target="_blank">this</a> for basic examples and API details.</p>

</div>
