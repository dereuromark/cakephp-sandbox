<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="form">
<h2>Confirmable Behavior</h2>
Test validation with Confirmable behavior attached.

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
