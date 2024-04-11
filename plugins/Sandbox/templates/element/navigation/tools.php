<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Tools plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-tools" target="_blank">[Tools Plugin]</a>
</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Tools Examples') ?></li>
	<li><?php echo $this->Navigation->link('Index', ['action' => 'index'])?></li>

	<li><?php echo $this->Navigation->link('Trim data input', ['action' => 'trim'])?></li>
	<li><?php echo $this->Navigation->link('Password (create account)', ['action' => 'password'])?></li>
	<li><?php echo $this->Navigation->link('Password Edit (edit account)', ['action' => 'passwordEdit'])?></li>
	<li><?php echo $this->Navigation->link('Password Edit with current pwd', ['action' => 'passwordEditCurrent'])?></li>

	<li><?php echo $this->Navigation->link('Trees', ['action' => 'tree'])?></li>
	<li><?php echo $this->Navigation->link('Typography', ['action' => 'typography'])?></li>
	<li><?php echo $this->Navigation->link('Confirmable Forms', ['action' => 'confirmable'])?></li>
	<li><?php echo $this->Navigation->link('Slugs', ['action' => 'slug'])?></li>
	<li><?php echo $this->Navigation->link('Datetime validation', ['action' => 'datetime'])?></li>

	<li><?php echo $this->Navigation->link('Format and Font Icons', ['action' => 'formatHelper'])?></li>

	<li><?php echo $this->Navigation->link('Gravatar images', ['action' => 'gravatar'])?></li>
	<li><?php echo $this->Navigation->link('Progress', ['action' => 'progress'])?></li>
	<li><?php echo $this->Navigation->link('Meter', ['action' => 'meter'])?></li>
	<li><?php echo $this->Navigation->link('Timeline', ['action' => 'timeline'])?></li>
</ul>
