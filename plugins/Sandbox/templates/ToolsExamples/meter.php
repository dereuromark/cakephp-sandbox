<?php
/**
 * @var \App\View\AppView $this
 * @var float $value
 * @var float $max
 * @var float $min
 * @var int $length
 */

if ($value === null) {
	$value = 4.1;
}
if ($length === null) {
	$length = 30;
}
if ($min === null) {
	$min = 0.0;
}
if ($max === null) {
	$max = 10.0;
}

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Meter</h2>
	<p>Use the Meter helper to display data within a given range (a gauge).</p>

<h3>Meter Bars</h3>
	<p>
		HTML based (with unicode fallback for IE and older browsers):
	</p>
	<?php
	$options = [
		'fallbackHtml' => $this->Meter->meterBar($value, $max, $min, $length),
	];
	echo $this->Meter->htmlMeterBar($value, $max, $min, $options);
	?>
	<p>This can be styled easily using CSS.</p>

	<br><br>

	<p>
		Text-based (unicode):
	</p>
	<?php
	echo $this->Meter->meterBar($value, $max, $min, $length);
	?>


	<br><br>

	<p>Adjust the rendered bar via form:</p>

	<?php
echo $this->Form->create(null, ['type' => 'get']);
echo $this->Form->control('value', ['label' => 'Value (float)', 'default' => (string)$value]);
echo $this->Form->control('max', ['label' => 'Max (float)', 'default' => (string)$max]);
echo $this->Form->control('min', ['label' => 'Min (float)', 'default' => (string)$min]);
//echo $this->Form->control('overflow', ['type' => 'checkbox', 'label' => 'Allow overflow', 'default' => $overflow]);

echo '<p>Onyl for text output:</p>';
echo $this->Form->control('length', ['label' => 'Int value 3...60', 'default' => (string)$length]);
echo $this->Form->submit('Render progress bar!');
echo $this->Form->end();
?>


</div>
