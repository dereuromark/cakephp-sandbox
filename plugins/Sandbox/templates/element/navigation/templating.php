<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Templating plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-templating" target="_blank">[Templating Plugin]</a>
</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Templating Examples') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Index', ['action' => 'index'], ['class' => 'nav-link'])?></li>

	<li class="nav-item"><?php echo $this->Navigation->link('HTML snippets', ['action' => 'html'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('(Font) Icons', ['action' => 'icons'], ['class' => 'nav-link' . ($this->getRequest()->getParam('action') === 'iconSets' ? ' active' : '')])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('SVG Icons', ['action' => 'svgIcons'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Icon Snippets', ['action' => 'iconSnippetHelper'], ['class' => 'nav-link'])?></li>
</ul>
