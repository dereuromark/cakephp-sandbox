<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Tools plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-template" target="_blank">[Template Plugin]</a>
</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Template Examples') ?></li>
	<li><?php echo $this->Navigation->link('Index', ['action' => 'index'])?></li>

	<li><?php echo $this->Navigation->link('(Font) Icons', ['action' => 'icons'], ['class' => $this->getRequest()->getParam('action') === 'iconSets' ? 'active' : null])?></li>
	<li><?php echo $this->Navigation->link('Icon Snippets', ['action' => 'iconSnippetHelper'])?></li>
</ul>
