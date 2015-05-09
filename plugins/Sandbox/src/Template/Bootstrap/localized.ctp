<h2>A localized form (German)</h2>
<p>Currently, mainly the date(time) fields have been localized.</p>

<?php

$this->Form->addWidget(
	'datetime',
	'Sandbox\View\Widget\DateTimeWidget'
);

echo $this->Form->create($animal, ['align' => 'horizontal']);
echo $this->Form->input('name');
echo $this->Form->input('comment', ['type' => 'textarea']);
echo $this->Form->input('discovered', ['type' => 'date']);
echo $this->Form->input('published', ['type' => 'datetime']);
echo $this->Form->input('time', ['type' => 'time', 'second' => true]);
echo $this->Form->input('confirmed', ['type' => 'checkbox']);

echo $this->Form->input('age', ['options' => ['Young', 'Old']]);
//echo $this->Form->input('gender', ['type' => 'radio', 'options' => ['Male', 'Female']]);

?>


<h2></h2>
