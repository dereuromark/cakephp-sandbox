<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Expose Plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-expose" target="_blank">[Expose Plugin]</a>
</p>

<h3>UUID Obfuscation</h3>
<p>Expose entities through UUIDs to hide primary key information from public URLs.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Overview'), ['controller' => 'ExposeExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Basic Usage') ?></li>
	<li><?php echo $this->Navigation->link('Users List', ['action' => 'users'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Superimposed Component') ?></li>
	<li><?php echo $this->Navigation->link('Superimposed Index', ['action' => 'superimposedIndex'])?></li>
</ul>
