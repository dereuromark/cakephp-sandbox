<?php
/**
 * @var \App\View\AppView $this
 */
?>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li class="nav-item"><?= $this->Html->link(__('Plugins'), ['controller' => 'PluginExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link(__('Ajax Plugin'), ['controller' => 'AjaxExamples', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Using CakePHP Core only') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Simple JSON response', ['action' => 'simple'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Pagination', ['action' => 'pagination'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Endless scroll (vertical pagination)', ['action' => 'endlessScroll'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Redirecting', ['action' => 'redirecting'], ['class' => 'nav-link'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Using Ajax Plugin') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Toggle', ['action' => 'toggle'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Buttons/Delete', ['action' => 'table'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Forms', ['action' => 'form'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Chained dropdowns', ['action' => 'chainedDropdowns'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Edit in Place', ['action' => 'editInPlace'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Redirecting (prevented)', ['action' => 'redirectingPrevented'], ['class' => 'nav-link'])?></li>
</ul>
