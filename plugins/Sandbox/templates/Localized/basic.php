<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $method
 * @var string|null $code
 * @var array $codes
 * @var array $methods
 * @var \App\Model\Entity\Entity|null $entity
 */

use Cake\Utility\Inflector;

?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?php echo $this->element('navigation/localized'); ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>Localized</h2>

<h3>Validation</h3>

<?php if (!$method) { ?>

	<?php foreach ($methods as $method) { ?>
		<li><?php echo $this->Html->link($method . ' validation', ['?' => ['method' => $method]]); ?></li>
	<?php } ?>

<?php } else { ?>

	<?php echo $this->Form->create($entity); ?>

	<?php echo $this->Form->control('value', ['label' => Inflector::humanize(Inflector::underscore($method))]); ?>
	<?php
	if ($codes) {
		echo $this->Form->control('code', ['label' => 'Country code', 'options' => $codes, 'default' => $code]);
	}
	?>

	<?php echo $this->Form->button('Run validation'); ?>

	<?php echo $this->Form->end(); ?>

<?php } ?>

</div>
