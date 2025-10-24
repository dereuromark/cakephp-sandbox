<?php
/**
 * @var \App\View\AppView $this
 * @var App\Model\Entity\Entity $animal
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<div class="form">
<h2>Confirmable Behavior</h2>
<p>Test validation with Confirmable behavior attached.</p>

<?php echo $this->Form->create($animal);?>
	<fieldset>
 		<legend><?php echo __('Validating your forms');?></legend>
	<?php
		echo $this->Form->control('name');
		echo $this->Form->control('confirm', ['type' => 'checkbox', 'label' => 'I confirm that I want to add this animal and that it is not yet present :)']);
	?>
	<?php echo $this->Form->submit(__('Submit')); ?>
	</fieldset>
<?php echo $this->Form->end();?>
</div>

<h3>Explanations</h3>
The confirm fields needs to be checked. This simple validation is added with a behavior:
<code><pre>$this->ModelName->addBehavior('Tools.Confirmable');
</pre></code>

</div></div>
