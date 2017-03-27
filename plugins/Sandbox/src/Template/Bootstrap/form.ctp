<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>A basic form</h2>

<?php
// Fix bootstrap container templates
$myTemplates = [
	'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}{{help}}</div>',
	'inputContainerError' => '<div class="form-group {{type}}{{required}} has-error">{{content}}{{error}}{{help}}</div>',
];
$this->Form->templates($myTemplates);

// Make selects bootstrap compatible
$this->Form->addWidget(
	'select',
	'Sandbox\View\Widget\SelectBoxWidget'
);

echo $this->Form->create($animal, ['align' => 'horizontal']);
echo $this->Form->input('name');
echo $this->Form->input('comment', ['type' => 'textarea']);
echo $this->Form->input('discovered', ['type' => 'date', 'class' => 'date']);
echo $this->Form->input('confirmed', ['type' => 'checkbox']);

echo $this->Form->input('age', ['options' => ['Young', 'Old']]);

echo $this->Form->input('gender', ['type' => 'radio', 'options' => ['Male', 'Female']]);

$options = [
	'Value 1' => 'Multiple choices',
	'Value 2' => 'Allowed'
];
echo $this->Form->input('options', ['type' => 'multicheckbox', 'options' => $options]);

echo $this->Form->end();
?>

<p>Note the break point, when you resize the browser. It will automatically jump from horizontal to non-horizontal at some point.</p>

<h2></h2>

<style>
.form-group.date .form-control,
.form-group.time .form-control,
.form-group.datetime .form-control {
	width: auto;
	display: inline-block;
	margin-right: 6px;
	margin-bottom: 2px;
}
</style>
