<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Tags plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-tags" target="_blank">[Tags Plugin]</a>
</p>

<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('Tagging in CakePHP') ?></li>
	<li><?php echo $this->Navigation->link('Simple string', ['action' => 'index'])?></li>
	<li><?php echo $this->Navigation->link('Select2 Multiple select', ['action' => 'select'])?></li>
	<li><?php echo $this->Navigation->link('Filtering', ['action' => 'search'])?></li>
	<li><?php echo $this->Navigation->link('Tag Cloud', ['action' => 'cloud'])?></li>
</ul>
