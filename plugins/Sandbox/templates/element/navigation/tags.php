<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Tags plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-tags" target="_blank">[Tags Plugin]</a>
</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Tagging in CakePHP') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Simple string', ['action' => 'index'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Select2 Multiple select', ['action' => 'select'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Filtering', ['action' => 'search'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Tag Cloud', ['action' => 'cloud'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Colors', ['action' => 'colors'], ['class' => 'nav-link'])?></li>
</ul>
