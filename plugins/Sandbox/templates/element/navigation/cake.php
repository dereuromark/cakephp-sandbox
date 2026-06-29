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
	<li class="nav-item"><?= $this->Html->link(__('Overview'), ['controller' => 'CakeExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Enums & Validation') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Enums', ['action' => 'enums'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Enum Validation', ['action' => 'enumValidation'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Validation Rules', ['action' => 'validation'], ['class' => 'nav-link'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Data & Arrays') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Array Merge', ['action' => 'merge'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Paginate Non-Database', ['action' => 'paginateNonDatabase'], ['class' => 'nav-link'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('I18n & Behaviors') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('I18n (Internationalization)', ['action' => 'i18n'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Translate Behavior', ['action' => 'translateBehavior'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Tree Behavior', ['controller' => 'ToolsExamples', 'action' => 'tree'], ['class' => 'nav-link'])?> (via Tools)</li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Other') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Query Strings', ['action' => 'queryStrings'], ['class' => 'nav-link'])?></li>
</ul>
