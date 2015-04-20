<div class="source-link" style="float: right;">
<?php //echo $this->SourceCode->link(null, array('class' => 'btn btn-info')); ?>
</div>

<h2>SASS and CakePHP</h2>
<p>
SASS is considered a really good alternative to LESS. With the AssetCompress plugin it can be easily used in CakePHP.
</p>
<p>The following example contains a variable for the color and font as well as a nested nav structure.
The compiled CSS (rendered in real time in the controller action when rails + sass is installed) is displayed below.
</p>
<h3>Demo/Example</h3>
<?php
	if (!empty($source)) {
		echo '<pre>';
		echo h($source);
		echo '</pre>';
	}
?>
becomes
<?php
	if (!empty($result)) {
		echo '<pre>';
		echo h($result);
		echo '</pre>';
	}
?>

Rendered successfully in real time? <?php echo $this->Format->yesNo(!empty($expected)); ?> <br>
(if no, please make sure sass via CLI is working).

<?php
if (!empty($expected) && $expected !== $result) {
	echo '<h4>Expected result</h4>';
	echo '<pre>';
	echo h($expected);
	echo '</pre>';
}
?>

<h3>Use cases</h3>
This is ideal when you want to keep things DRY.
You can easily have PHP inject the data for the variables (e.g. $color) and create customizable schemes.
