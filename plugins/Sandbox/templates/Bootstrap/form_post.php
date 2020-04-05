<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entity $animal
 */
?>
<h2>Posting forms, invalidation and keeping changes</h2>

<?php
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

