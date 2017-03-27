<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page index">


<h2>Forms and Captchas</h2>

	<?= $this->Form->create($animal, ['novalidate' => true]) ?>
	<fieldset>
		<legend><?= __('Add Animal') ?></legend>
		<?php
		echo $this->Form->input('name');

		echo $this->Captcha->render(['placeholder' => __('Please solve the riddle')]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>

	<p>Note: You can only save "Mouse" or "Cat" as animals for this demo!</p>

<h3>Key Goals</h3>
<ul>
	<li>Simple and unobstrusive</li>
	<li>Without much dependencies or requirements</li>
	<li>Highly extendable</li>
</ul>
