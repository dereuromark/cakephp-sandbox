<?php
/**
 * @var \App\View\AppView $this
 * @var array<string> $operations
 * @var mixed $result
 */

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

	<h3>API Demo</h3>

	<p>Take value one and two and chose what operation to do on them.</p>

	<?php echo $this->Form->create();?>
	<fieldset>
		<legend><?php echo __('Set values');?></legend>

		<p>You can set integers or floating-point numbers.</p>

		<?php
		echo $this->Form->control('one', ['placeholder' => 'Format: 0 or 0.00']);
		echo $this->Form->control('two', ['placeholder' => 'Format: 0 or 0.00']);
		?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('Operation');?></legend>

		<?php
		echo $this->Form->control('operation', ['options' => $operations]);
		?>
	</fieldset>

	<?php
	echo $this->Form->submit(__('Submit'));
	echo $this->Form->end();
	?>

	<h3>Result</h3>
	<?php if ($result !== null) {
		if ($result === false) {
			$result = 'false';
		} elseif ($result === true) {
			$result = 'true';
		}

 		echo $this->Highlighter->highlight(print_r($result, true), ['lang' => 'php']);
	} else {
		echo '<p>';
		echo '---';
		echo '</p>';
	} ?>

	<p>Some notes:</p>
	<ul>
		<li>multiply() by default adds the scales of each number.</li>
		<li>
			divide() requires a 2nd param scale, and right now the demo defaults to the max scale of the two numbers.
			<br>
			So <code>1</code> and <code>2</code> result in <code>0</code> as the scale of that result cuts of the decimal values.
		</li>
	</ul>

</div></div>
