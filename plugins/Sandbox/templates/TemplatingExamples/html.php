<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/templating'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>HTML Snippets</h2>

	<h3>Using Html value object</h3>

	<?php
	$text = <<<TEXT
\$text = \Templating\View\Html::create('<i>Some text</i>');
echo \$this->Html->link(\$text, '/');
TEXT;
	echo $this->Highlighter->highlight($text, ['lang' => 'php']);
	?>

	<p>results in</p>

	<pre><?php
		$text = \Templating\View\Html::create('<i>Some text</i>');
		echo $this->Html->link($text, '/');
		?>
	</pre>

	<p>No escapeTitle necessary here anymore.</p>

</div></div>
