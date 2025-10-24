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
	<li><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Overview'), ['controller' => 'MarkupExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Code Highlighting') ?></li>
	<li><?php echo $this->Navigation->link('Highlighting (PHP or JS)', ['action' => 'markup'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Code Transformation') ?></li>
	<li><?php echo $this->Navigation->link('BBCode', ['action' => 'bbcode'])?></li>
	<li><?php echo $this->Navigation->link('Markdown', ['action' => 'markdown'])?></li>
</ul>
