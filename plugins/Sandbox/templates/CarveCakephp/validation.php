<?php /** @var \App\View\AppView $this */ ?>
<nav class="actions col-md-2 col-sm-3 col-12"><?= $this->element('navigation/carve') ?></nav>
<div class="col-md-10 col-sm-9 col-12">
<h2>Carve validation</h2>
<?= $this->Form->create($form) ?>
<?= $this->Form->control('body', ['type' => 'textarea', 'value' => $data['body'], 'rows' => 8]) ?>
<?= $this->Form->control('preset', ['type' => 'select', 'options' => ['default' => 'default', 'comment' => 'comment'], 'value' => $data['preset']]) ?>
<?= $this->Form->control('maxLength', ['type' => 'number', 'value' => $data['maxLength'], 'min' => 1]) ?>
<?= $this->Form->control('lint', ['type' => 'checkbox', 'checked' => $data['lint']]) ?>
<?= $this->Form->button('Validate') ?>
<?= $this->Form->end() ?>
<?php if ($renderedBody !== null) { ?><h3>Rendered HTML</h3><div class="carve-output"><?= $this->Carve->convert($renderedBody, ['preset' => $renderedPreset]) ?></div><?php } ?>
<h3>Validator setup</h3>
<pre><?= h(<<<'CODE'
$validator->setProvider('carve', CarveValidation::class)
	->add('body', 'carve', [
		'rule' => ['valid', ['preset' => $preset, 'maxLength' => $maxLength, 'lint' => $lint]],
		'provider' => 'carve',
	]);
CODE) ?></pre>
</div>
