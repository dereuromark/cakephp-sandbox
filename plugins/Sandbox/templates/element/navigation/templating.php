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
	<li><?php echo $this->Navigation->link('Index', ['action' => 'index'])?></li>

	<li><?php echo $this->Navigation->link('HTML snippets', ['action' => 'html'])?></li>
	<li><?php echo $this->Navigation->link('(Font) Icons', ['action' => 'icons'], ['class' => $this->getRequest()->getParam('action') === 'iconSets' ? 'active' : null])?></li>
	<li><?php echo $this->Navigation->link('SVG Icons', ['action' => 'svgIcons'])?></li>
	<li><?php echo $this->Navigation->link('Icon Snippets', ['action' => 'iconSnippetHelper'])?></li>
</ul>
