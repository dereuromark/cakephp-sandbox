<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Format Helper</h2>

<h3>Specific Icons</h3>
<code style="display: block;">
<?php
$text = <<<TEXT
<?php echo \$this->Format->yesNo(\$boolValue); ?>
TEXT;
echo h($text);
?>
</code>

<?php
echo $this->Format->yesNo(1);
echo '<br>';
echo $this->Format->yesNo(0);
?>

<br><br>

<code style="display: block;">
	<?php
	$text = <<<TEXT
<?php echo \$this->Format->thumbs(\$boolValue); ?>
TEXT;
	echo h($text);
	?>
</code>


<div style="font-size: 18px;">
<?php
echo $this->Format->thumbs(1);
echo '<br>';
echo $this->Format->thumbs(0);
?>
</div>

	<br><br>

	<code style="display: block;">
		<?php
		$text = <<<TEXT
<?php echo \$this->Format->genderIcon(\$genderValue); ?>
TEXT;
		echo h($text);
		?>
	</code>

	<div style="font-size: 18px;">
		<?php
		echo $this->Format->genderIcon(\Tools\View\Helper\FormatHelper::GENDER_FEMALE);
		echo '<br>';
		echo $this->Format->genderIcon(\Tools\View\Helper\FormatHelper::GENDER_MALE);
		echo '<br>';
		echo $this->Format->genderIcon(0);
		?>
	</div>

	<br><br>

	<h3>Other</h3>
<code style="display: block;">
	<?php
	$text = <<<TEXT
<?php echo \$this->Format->ok('I am OK', 1); ?>
<?php echo \$this->Format->ok('Me not so much', 0); ?>
TEXT;
	echo nl2br(h($text));
	?>
</code>

<?php
echo $this->Format->ok('I am OK', 1);
echo '<br>';
echo $this->Format->ok('Me not so much', 0)
?>

	<br><br>

<h3>Array to Table</h3>
<code style="display: block;">
	<?php
	$text = <<<TEXT
\$array = [
	['x' => '0', 'y' => '0.5', 'z' => '0.9'],
	['1', '2', '3'],
	['4', '5', '6']
];
echo \$this->Format->array2table(\$array);
TEXT;
	echo nl2br(h($text));
	?>
</code>

<?php
$array = [
	['x' => '0', 'y' => '0.5', 'z' => '0.9'],
	['1', '2', '3'],
	['4', '5', '6'],
];
echo $this->Format->array2table($array);

?>

</div></div>
