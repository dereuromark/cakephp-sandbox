<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>CakePHP Examples</h2>

<h3>Core CakePHP Features</h3>
<p>Examples showcasing built-in CakePHP functionality and best practices.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li><?= $this->Html->link(__('Overview'), ['controller' => 'CakeExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Enums & Validation') ?></li>
	<li><?php echo $this->Navigation->link('Enums', ['action' => 'enums'])?></li>
	<li><?php echo $this->Navigation->link('Enum Validation', ['action' => 'enumValidation'])?></li>
	<li><?php echo $this->Navigation->link('Validation Rules', ['action' => 'validation'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Data & Arrays') ?></li>
	<li><?php echo $this->Navigation->link('Array Merge', ['action' => 'merge'])?></li>
	<li><?php echo $this->Navigation->link('Paginate Non-Database', ['action' => 'paginateNonDatabase'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('I18n & Behaviors') ?></li>
	<li><?php echo $this->Navigation->link('I18n (Internationalization)', ['action' => 'i18n'])?></li>
	<li><?php echo $this->Navigation->link('Translate Behavior', ['action' => 'translateBehavior'])?></li>
	<li><?php echo $this->Navigation->link('Tree Behavior', ['controller' => 'ToolsExamples', 'action' => 'tree'])?> (via Tools)</li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Other') ?></li>
	<li><?php echo $this->Navigation->link('Query Strings', ['action' => 'queryStrings'])?></li>
</ul>
