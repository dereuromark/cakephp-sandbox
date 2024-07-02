<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Comments Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-comments" target="_blank">[Comments Plugin]</a>
</p>

<h3>"Comments"</h3>
<p>lets people comment on any model entity in minutes!</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('') ?></li>
	<li><?php echo $this->Navigation->link('Overview', ['action' => 'index'])?></li>
	<li><?php echo $this->Navigation->link('Basic', ['action' => 'basic'])?></li>
</ul>
