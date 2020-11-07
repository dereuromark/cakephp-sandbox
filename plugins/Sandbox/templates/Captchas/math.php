<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entity $animal
 */
?>
<div class="page index">


<h2>Forms and Captchas</h2>

	<?= $this->Form->create($animal, ['novalidate' => true]) ?>
	<fieldset>
		<legend><?= __('Add Animal') ?></legend>
		<?php
		echo $this->Form->control('name');

		echo $this->Captcha->render(['placeholder' => __('Please solve the riddle')]);
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>

	<br><br>
	<p>Note: There is also a 2 second min-time by default! If you (as bot) do it too fast, this is also punished.</p>

<h3>Key Goals</h3>
<ul>
	<li>Simple and unobstrusive</li>
	<li>Without much dependencies or requirements</li>
	<li>Highly extendable</li>
</ul>
