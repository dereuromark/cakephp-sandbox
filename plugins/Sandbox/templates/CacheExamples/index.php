<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cache'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Overview</h3>
<p>
	The Cache plugin provides component-based caching for controller actions and views in CakePHP.
</p>

<h3>Examples</h3>
<?php echo $this->element('Sandbox.actions'); ?>

<h3>Example with extension</h3>
<ul>
	<li><?php echo $this->Html->link('JSON file', ['action' => 'someJson', '_ext' => 'json']); ?></li>
</ul>

</div></div>
