<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Markup Plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-markup" target="_blank">[Markup Plugin]</a>
</p>

<h3>Text Markup Examples</h3>
<p>Code highlighting and text transformation tools.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li class="nav-item"><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link(__('Overview'), ['controller' => 'MarkupExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Code Highlighting') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Highlighting (PHP or JS)', ['action' => 'markup'], ['class' => 'nav-link'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Code Transformation') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('BBCode', ['action' => 'bbcode'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Markdown', ['action' => 'markdown'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Djot', ['action' => 'djot'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('DjotView', ['action' => 'djotView'], ['class' => 'nav-link']); ?></li>
</ul>
