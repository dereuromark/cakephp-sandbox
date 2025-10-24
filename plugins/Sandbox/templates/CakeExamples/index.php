<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Overview</h3>
<p>
	Examples demonstrating core CakePHP functionality including enums, validation, internationalization, and data handling.
</p>

<?php if (version_compare(phpversion(), '5.5', '>=')) { ?>
	<h4>Core functionality</h4>
	<ul>
		<li><?php echo $this->Html->link('Chronos (standalone DateTime extension)', ['controller' => 'ChronosExamples', 'action' => 'index'])?></li>
	</ul>
<?php } ?>

<h3>Examples</h3>
<?php echo $this->element('Sandbox.actions'); ?>

</div></div>
