<?php
/**
 * @var \App\View\AppView $this
 * @var array $someTestArray
 */
$this->loadHelper('Templating.Icon');
?>
<h1>Some header</h1>
<p>A paragrah with <b>Bold text</b>!</p>

<h2>Some h2 header</h2>
<ul>
	<li>This uses the templates/PdfTest/pdf/pdf_test.php template</li>
	<li>And the layout templates/layout/pdf/default.php</li>
</ul>

<h3>Some h3 header</h3>
<div style="width: 300px;">
	<div style="float: right;"><?php echo $this->Icon->render('edit'); ?> Floating Icon gif</div>
	<div style="float: right;"><?php echo $this->Html->image(\Cake\Routing\Router::fullBaseUrl() . '/img/icons/paste.png', ['alt' => 'go-down']); ?> Floating Icon png</div>
</div>

<p>$someTestArray[Foo][bar] content: <?php echo h($someTestArray['Foo']['bar']); ?></p>

<hr style="clear: all;" />

<table style="width: 100%;">
	<tr><th>Table head</th><th>Table head two</th></tr>
	<tr><td>Table content</td><td>Table content two</td></tr>
</table>
