<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entity $animal
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

echo $this->Form->end();
?>

<p>Note the break point, when you resize the browser. It will automatically jump from horizontal to non-horizontal at some point.</p>
