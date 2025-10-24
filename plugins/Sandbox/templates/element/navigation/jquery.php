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
	<li><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Overview'), ['controller' => 'JqueryExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('jQuery Examples') ?></li>
	<li><?php echo $this->Navigation->link('Autocomplete', ['action' => 'autocomplete'])?></li>
	<li><?php echo $this->Navigation->link('Auto Preview', ['action' => 'autopreview'])?></li>
	<li><?php echo $this->Navigation->link('Maxlength', ['action' => 'maxlength'])?></li>
</ul>
