<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Flash Plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-flash" target="_blank">[Flash Plugin]</a>
</p>

<h3>Flash Message Examples</h3>
<p>Advanced flash messaging with AJAX support and transient messages.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Overview'), ['controller' => 'FlashExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Basic Flash Messages') ?></li>
	<li><?php echo $this->Navigation->link('All flash message types', ['action' => 'messages'])?></li>
	<li><?php echo $this->Navigation->link('Grouped types', ['action' => 'messageGroups'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('AJAX Integration') ?></li>
	<li><?php echo $this->Navigation->link('AJAX Buttons', ['action' => 'ajax'])?></li>
	<li><?php echo $this->Navigation->link('AJAX with Ajax Plugin', ['action' => 'ajaxPlugin'])?></li>
</ul>
