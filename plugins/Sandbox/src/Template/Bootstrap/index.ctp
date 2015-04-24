<h2>A basic form</h2>

<?php

echo $this->Form->create($animal, ['align' => 'horizontal']);
echo $this->Form->input('name');
echo $this->Form->input('comment', ['type' => 'textarea']);
echo $this->Form->input('discovered', ['type' => 'date']);
echo $this->Form->input('confirmed', ['type' => 'checkbox']);

echo $this->Form->input('age', ['options' => ['Young', 'Old']]);
//echo $this->Form->input('gender', ['type' => 'radio', 'options' => ['Male', 'Female']]);

?>

<p>Note the break point, when you resize the browser. It will automatically jump from horizontal to non-horizontal at some point.</p>

<h2></h2>
