<?php
/**
 * @var \App\View\AppView $this
 * @var App\Model\Entity\Entity $entity
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<div class="form">
<h2>Datetime validation</h2>

	<p>Test validation with datetime input.</p>

<?php echo $this->Form->create($entity);?>
	<fieldset>
 		<legend><?php echo __('Validating your forms');?></legend>
	<?php
		echo $this->Form->control('from', ['type' => 'date']);
		echo $this->Form->control('to', ['type' => 'date']);
	?>
	<?php echo $this->Form->submit(__('Submit')); ?>
	</fieldset>
<?php echo $this->Form->end();?>
</div>

<h3>Explanations</h3>
The "from" date must come before "to".

</div></div>
