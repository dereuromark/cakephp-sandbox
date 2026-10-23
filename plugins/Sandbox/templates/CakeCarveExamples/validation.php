<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, mixed> $data
 * @var \Cake\Form\Form $form
 * @var string|null $renderedBody
 * @var string|null $renderedPreset
 */

echo $this->element('cake_carve/highlighting');
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake_carve'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Validation</h3>
	<p>
		<code>CarveValidation</code> is a validator provider. It fails on markup the preset's profile disallows,
		on lint findings when <code>lint</code> is on, and on rendered text longer than <code>maxLength</code>.
		The prefilled heading fails under the <code>comment</code> preset; switch to <code>default</code> and it passes.
	</p>

	<?php echo $this->Form->create($form); ?>
	<?php echo $this->Form->control('body', ['type' => 'textarea', 'value' => $data['body'], 'rows' => 6]); ?>
	<?php echo $this->Form->control('preset', ['type' => 'select', 'options' => ['default' => 'default', 'comment' => 'comment'], 'value' => $data['preset']]); ?>
	<?php echo $this->Form->control('maxLength', ['type' => 'number', 'value' => $data['maxLength'], 'min' => 1]); ?>
	<?php echo $this->Form->control('lint', ['type' => 'checkbox', 'checked' => $data['lint']]); ?>
	<?php echo $this->Form->button('Validate', ['class' => 'btn btn-primary']); ?>
	<?php echo $this->Form->end(); ?>

	<?php if ($renderedBody !== null) { ?>
		<h4 class="mt-3">Valid, rendered</h4>
		<div class="carve-output carve-rendered border rounded p-2"><?php echo $this->Carve->convert($renderedBody, ['preset' => $renderedPreset]); ?></div>
	<?php } ?>

	<h3 class="mt-4">Validator setup</h3>
	<?php echo $this->element('cake_carve/code', ['code' => <<<'PHP'
use MarkupCarve\CakeCarve\Validation\CarveValidation;

$validator->setProvider('carve', CarveValidation::class)
	->add('body', 'carve', [
		'rule' => ['valid', ['preset' => 'comment', 'maxLength' => 200, 'lint' => true]],
		'provider' => 'carve',
	]);
PHP, 'lang' => 'php']); ?>

</div>
</div>
