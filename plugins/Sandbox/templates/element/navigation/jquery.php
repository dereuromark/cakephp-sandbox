<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>jQuery Examples</h2>

<h3>jQuery UI & Plugins</h3>
<p>Examples using jQuery and popular jQuery plugins.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li class="nav-item"><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link(__('Overview'), ['controller' => 'JqueryExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('jQuery Examples') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Autocomplete', ['action' => 'autocomplete'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Auto Preview', ['action' => 'autopreview'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Maxlength', ['action' => 'maxlength'], ['class' => 'nav-link'])?></li>
</ul>
