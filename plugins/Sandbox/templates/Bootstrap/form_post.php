<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entity $animal
 */
?>
<h2>Posting forms, invalidation and keeping changes</h2>

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
echo $this->Form->control('confirmed', ['type' => 'checkbox']);

echo $this->Form->control('multiple_checkboxes', ['multiple' => 'checkbox', 'options' => ['Young', 'Old', 'Hipster', 'Cool', 'Blue']]);

echo $this->Form->control('multiple_selects', ['multiple' => true, 'options' => ['Young', 'Old', 'Hipster', 'Cool', 'Blue']]);

echo '<div class="form-group">';
echo $this->Form->control(__('Submit'), ['type' => 'submit']);
echo '</div>';

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
