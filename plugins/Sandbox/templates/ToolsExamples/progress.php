<?php
/**
 * @var \App\View\AppView $this
 * @var float $value
 * @var int $length
 */

if ($value === null) {
	$value = 0.41;
}
if ($length === null) {
	$length = 30;
}

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Progress</h2>
	<p>
		Use the Progress helper to display basic progress bars the easy way.
	</p>

<h3>Progress Bars</h3>
	<p>
	HTML based (with unicode fallback for IE and older browsers):
	</p>
	<?php
	$options = [
		'fallbackHtml' => $this->Progress->progressBar($value, $length),
	];
	echo $this->Progress->htmlProgressBar($value, $options);
	?>
	<p>This can be styled easily using CSS.</p>

	<br><br>

	<p>
	Text-based (unicode):
	</p>
	<?php
	echo $this->Progress->progressBar($value, $length);
	?>


	<br><br>

	<p>Adjust the rendered bar via form:</p>

	<?php
echo $this->Form->create(null, ['type' => 'get']);
echo $this->Form->control('value', ['label' => 'Float value 0...1', 'default' => $value]);

echo '<p>Onyl for text output:</p>';
echo $this->Form->control('length', ['label' => 'Int value 3...60', 'default' => $length]);
echo $this->Form->submit('Render progress bar!');
echo $this->Form->end();
?>


</div>
