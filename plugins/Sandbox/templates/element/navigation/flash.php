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
	<li class="nav-item"><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link(__('Overview'), ['controller' => 'FlashExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Basic Flash Messages') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('All flash message types', ['action' => 'messages'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Grouped types', ['action' => 'messageGroups'], ['class' => 'nav-link'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('AJAX Integration') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('AJAX Buttons', ['action' => 'ajax'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('AJAX with Ajax Plugin', ['action' => 'ajaxPlugin'], ['class' => 'nav-link'])?></li>
</ul>
