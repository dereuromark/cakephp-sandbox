<?php
/**
 * @var \App\View\AppView $this
 */

$action = $this->request->getParam('action');
?>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Converters') ?></li>
	<li class="nav-item"><?= $this->Html->link('Djot Playground', ['action' => 'index'], ['class' => 'nav-link' . ($action === 'index' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Complex Examples', ['action' => 'complexExamples'], ['class' => 'nav-link' . ($action === 'complexExamples' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Extensions', ['action' => 'extensions'], ['class' => 'nav-link' . ($action === 'extensions' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Markdown to Djot', ['action' => 'markdownToDjot'], ['class' => 'nav-link' . ($action === 'markdownToDjot' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('HTML to Djot', ['action' => 'htmlToDjot'], ['class' => 'nav-link' . ($action === 'htmlToDjot' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Links') ?></li>
	<li class="nav-item"><?= $this->Html->link('Djot-PHP', 'https://github.com/php-collective/djot-php', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link('Djot Spec', 'https://djot.net', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link('Cheatsheet', 'https://htmlpreview.github.io/?https://github.com/jgm/djot/blob/master/doc/cheatsheet.html', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link('Pandoc', 'https://pandoc.org/', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
</ul>
