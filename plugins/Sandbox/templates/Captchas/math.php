<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\Animal $animal
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?= $this->element('navigation/captchas') ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>Math Captcha</h2>
<p>A classic image-based captcha that presents a simple math problem to solve.</p>

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

<h3 class="mt-4">Notes</h3>
<ul>
	<li>There is a 2 second min-time by default. If you (as bot) submit too fast, the captcha is invalidated.</li>
	<li>The <code>Captcha.maxPerUser</code> value sets a flood limit (currently <?= h((string)$this->Configure->readOrFail('Captcha.maxPerUser')) ?> per hour) to avoid brute-force attempts.</li>
</ul>
<p>
	For testing purposes you can reset the DB for your user: <?= $this->Html->link('Reset', ['action' => 'math', '?' => ['reset' => '1']], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
</p>

</div>
