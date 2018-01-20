<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>A localized form (German)</h2>
<p>Currently, mainly the date(time) fields have been localized.</p>

<?php

$this->Form->addWidget(
	'datetime',
	'Sandbox\View\Widget\DateTimeWidget'
);

echo $this->Form->create($animal, ['align' => 'horizontal']);
echo $this->Form->control('name');
echo $this->Form->control('comment', ['type' => 'textarea']);
echo $this->Form->control('discovered', ['type' => 'date', 'default' => true]);
echo $this->Form->control('published', ['type' => 'datetime']);
echo $this->Form->control('time', ['type' => 'time', 'second' => true]);
echo $this->Form->control('confirmed', ['type' => 'checkbox']);

echo $this->Form->control('age', ['options' => ['Young', 'Old']]);
//echo $this->Form->control('gender', ['type' => 'radio', 'options' => ['Male', 'Female']]);


echo $this->Form->end();
?>


<h2></h2>
