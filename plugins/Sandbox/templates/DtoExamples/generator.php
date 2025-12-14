<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array<string, mixed>> $demos
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Schema Generator</h3>
	<p>Generate the DTO schema from JSON schema or JSON example data.</p>

	<p><?php echo $this->Html->link('Try it out (empty form)', ['prefix' => 'Admin', 'plugin' => 'CakeDto', 'controller' => 'Generate', 'action' => 'index']); ?></p>

<h4>Quick Links with Demo Data</h4>
	<p>Pre-fill the generator form with example data:</p>
	<ul>
	<?php foreach ($demos as $key => $demo) { ?>
		<li>
			<?php
			echo $this->Html->link($demo['label'], [
				'prefix' => 'Admin',
				'plugin' => 'CakeDto',
				'controller' => 'Generate',
				'action' => 'schema',
				'?' => [
					'input' => $demo['data'],
					'type' => $demo['type'],
					'namespace' => $demo['namespace'],
					'compressed' => '1',
				],
			]);
			?>
		</li>
	<?php } ?>
	</ul>

<h4>External JSON Schema Examples</h4>
	<p>Copy-paste from these external sources:</p>
	<ul>
		<li><?php echo $this->Html->link('GitHub REST API OpenAPI Schema', 'https://github.com/github/rest-api-description', ['target' => '_blank']); ?></li>
		<li><?php echo $this->Html->link('JSON Schema Store (various schemas)', 'https://www.schemastore.org/json/', ['target' => '_blank']); ?></li>
	</ul>

</div></div>
