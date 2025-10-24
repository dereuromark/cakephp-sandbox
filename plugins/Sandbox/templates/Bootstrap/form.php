<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entity $animal
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/bootstrap'); ?>
</nav>
<div class="page form col-sm-8 col-12">

<h3>Basic Form (Horizontal Layout)</h3>

<fieldset>
<?php
echo $this->Form->create($animal, ['align' => 'horizontal']);
echo $this->Form->control('name');
echo $this->Form->control('comment', ['type' => 'textarea']);
echo $this->Form->control('discovered', ['type' => 'date', 'class' => 'date']);
echo $this->Form->control('confirmed', ['type' => 'checkbox']);

echo $this->Form->control('age', ['options' => ['Young', 'Old']]);

echo $this->Form->control('gender', ['type' => 'radio', 'options' => ['Male', 'Female']]);

$options = [
	'Value 1' => 'Multiple choices',
	'Value 2' => 'Allowed',
];
echo $this->Form->control('options', ['type' => 'multicheckbox', 'options' => $options]);

echo $this->Form->submit('Submit');
echo $this->Form->end();
?>
</fieldset>

<p>Note the break point, when you resize the browser. It will automatically jump from horizontal to non-horizontal at some point.</p>

</div>
</div>
