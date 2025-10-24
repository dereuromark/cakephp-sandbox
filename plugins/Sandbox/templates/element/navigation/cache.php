<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Cache Plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-cache" target="_blank">[Cache Plugin]</a>
</p>

<h3>View Caching Examples</h3>
<p>Component-based caching for controller actions and views.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Overview'), ['controller' => 'CacheExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Caching Examples') ?></li>
	<li><?php echo $this->Navigation->link('Minute Cache', ['action' => 'minute'])?></li>
	<li><?php echo $this->Navigation->link('Hour Cache', ['action' => 'hour'])?></li>
</ul>
