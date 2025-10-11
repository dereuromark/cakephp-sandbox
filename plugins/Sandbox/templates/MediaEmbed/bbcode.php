<?php
/**
 * @var \App\View\AppView $this
 * @var string $bbcode
 * @var string $bbcodeExample
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?php echo $this->element('navigation/media_embed'); ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

	<h2>MediaEmbed</h2>

	<h3>BBCode Example</h3>

	<?php
	echo $this->Form->create();
	echo $this->Form->control('bbcode', ['default' => $bbcodeExample, 'type' => 'textarea', 'rows' => 3]);
	echo $this->Form->submit();
	echo $this->Form->end();
	?>

	<?php
	if (!empty($bbcode)) {
		?>
		<h3>Result</h3>
		<?php
			$this->loadHelper('Sandbox.MediaEmbedBbcode');
			$html = $this->MediaEmbedBbcode->prepareForOutput($bbcode);

			echo $html;
		?>

		<h4>HTML</h4>
		<pre><?php echo h(print_r($html, true)); ?></pre>
		<?php
	}
	?>

</div>
