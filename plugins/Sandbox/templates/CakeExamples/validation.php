<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entity $animal
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<div class="form">
<h2>Validation</h2>
Test validation on marshal and rules on save.

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
In the form above the name must be present and unique (not existing in the current table).
<br />
So "Dog" or "Frog" fails because it already exists.
Furthermore the confirm fields needs to be checked.
<br />
This is all validation (on marshal).
<br /><br />
Domain rules are run separately afterwards.
The example one here checks if the data in name is equal to either "Mouse" or "Cat" and only then
allows the rules to pass - and thus to save.
<br /><br />
Check it out yourself. Unfortunately, there is no feedback on the failing domain rules.
And it seems they run only when validation itself passed, so it is a two-step process.
So I would recommend to skip them as much as possible, and shift all validation focus on
the validation level (marshal) then.

</div></div>
