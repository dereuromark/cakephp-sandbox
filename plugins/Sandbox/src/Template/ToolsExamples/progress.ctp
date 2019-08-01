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

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

<h2>Progress</h2>

<h3>Progress Bars</h3>
<p>
Use the Progress helper to display basic text-based (unicode) progress bars the easy way.

</p>


	<?php
	echo $this->Progress->progressBar($value, $length); #
	?>


	<br><br>

	<p>Adjust the rendered bar via form:</p>

	<?php
echo $this->Form->create(false, ['type' => 'get']);
echo $this->Form->control('value', ['label' => 'Float value 0...1', 'default' => $value]);
echo $this->Form->control('length', ['label' => 'Int value 3...60', 'default' => $length]);
echo $this->Form->submit('Render progress bar!');
echo $this->Form->end();
?>


</div>
