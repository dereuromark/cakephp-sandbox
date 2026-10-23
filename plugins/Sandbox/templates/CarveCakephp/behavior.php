<?php /** @var \App\View\AppView $this */ ?>
<nav class="actions col-md-2 col-sm-3 col-12"><?= $this->element('navigation/carve') ?></nav>
<div class="col-md-10 col-sm-9 col-12">
<h2>Carve behavior</h2>
<p>This example saves to an in-memory SQLite table.</p>
<?= $this->Form->create(null) ?>
<?= $this->Form->control('body', ['type' => 'textarea', 'value' => $data['body'], 'rows' => 8]) ?>
<?= $this->Form->button('Save') ?>
<?= $this->Form->end() ?>
<?php if ($row !== null) { ?>
<h3>Saved row</h3>
<?php foreach ($row as $column => $value) { ?>
<h4><?= h($column) ?></h4>
<pre><?= h(is_array($value) ? json_encode($value, JSON_PRETTY_PRINT) : (string)$value) ?></pre>
<?php } ?>
<?php } ?>
<h3>Behavior config</h3>
<pre><?= h(<<<'CODE'
$posts->addBehavior('MarkupCarve/CakeCarve.Carve', [
	'fields' => ['body' => ['target' => 'body_html', 'text' => 'body_text', 'toc' => 'body_toc']],
]);
CODE) ?></pre>
</div>
