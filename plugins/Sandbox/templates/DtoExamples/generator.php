<?php
/**
 * @var \App\View\AppView $this
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Schema Generator</h3>
	<p>Generate the DTO schema from JSON schema or JSON example data</p>

	<p><?php echo $this->Html->link('Try it out', ['prefix' => 'Admin', 'plugin' => 'CakeDto', 'controller' => 'Generate', 'action' => 'index']);?></p>

</div>
