<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Working with time inputs</h2>

<?php

$this->Form->addWidget(
	'clockTime',
	'Sandbox\View\Widget\ClockTimeWidget'
);

$this->Form->addWidget(
	'datetime',
	'Sandbox\View\Widget\DateTimeWidget'
);

echo $this->Form->create($animal, ['align' => 'horizontal']);
echo $this->Form->control('time', ['type' => 'clockTime']);

echo $this->Form->control('time_with_seconds', ['type' => 'clockTime', 'second' => true]);

echo $this->Form->end();

?>

<p>With seconds involved it falls back to the default one</p>
