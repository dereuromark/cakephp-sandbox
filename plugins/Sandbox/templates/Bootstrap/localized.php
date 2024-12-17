<?php
/**
 * @var \App\View\AppView $this
 * @var App\Model\Entity\Entity $animal
 */
?>

<div class="row">
	<div class="col-md-12">

<h2>A localized form (German)</h2>
<p>Currently, mainly the date(time) fields have been localized.</p>

<?php

// Usually this is added globally in bootstrap or app config.
$this->Form->addWidget(
	'datetime',
	['Sandbox\View\Widget\DateTimeWidget', '_view']
);

echo $this->Form->create($animal, ['align' => 'horizontal']);
echo $this->Form->control('discovered', ['type' => 'date', 'default' => true]);
echo $this->Form->control('published', ['type' => 'datetime']);
echo $this->Form->control('time', ['type' => 'time', 'second' => true]);
echo $this->Form->control('confirmed', ['type' => 'checkbox']);

echo $this->Form->control('age', ['options' => ['Young', 'Old']]);
//echo $this->Form->control('gender', ['type' => 'radio', 'options' => ['Male', 'Female']]);

echo $this->Form->control(__('Submit'), ['type' => 'submit']);

echo $this->Form->end();
?>


	</div>
</div>
