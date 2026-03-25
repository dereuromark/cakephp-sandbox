<?php
/**
 * @var \App\View\AppView $this
 */

$action = $this->request->getParam('action');
?>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('TOML') ?></li>
	<li class="nav-item"><?= $this->Html->link('Playground', ['action' => 'index'], ['class' => 'nav-link' . ($action === 'index' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Examples', ['action' => 'examples'], ['class' => 'nav-link' . ($action === 'examples' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Validation', ['action' => 'validation'], ['class' => 'nav-link' . ($action === 'validation' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Links') ?></li>
	<li class="nav-item"><?= $this->Html->link('TOML-PHP', 'https://github.com/php-collective/toml', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link('TOML Spec', 'https://toml.io', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
</ul>
