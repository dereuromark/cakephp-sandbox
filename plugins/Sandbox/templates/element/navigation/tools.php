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
	<li class="nav-item"><?php echo $this->Navigation->link('Index', ['action' => 'index'], ['class' => 'nav-link'])?></li>

	<li class="nav-item"><?php echo $this->Navigation->link('Trim data input', ['action' => 'trim'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Password (create account)', ['action' => 'password'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Password Edit (edit account)', ['action' => 'passwordEdit'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Password Edit with current pwd', ['action' => 'passwordEditCurrent'], ['class' => 'nav-link'])?></li>

	<li class="nav-item"><?php echo $this->Navigation->link('Trees', ['action' => 'tree'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Typography', ['action' => 'typography'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Confirmable Forms', ['action' => 'confirmable'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Slugs', ['action' => 'slug'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Datetime validation', ['action' => 'datetime'], ['class' => 'nav-link'])?></li>

	<li class="nav-item"><?php echo $this->Navigation->link('Format and Font Icons', ['action' => 'formatHelper'], ['class' => 'nav-link'])?></li>

	<li class="nav-item"><?php echo $this->Navigation->link('Gravatar images', ['action' => 'gravatar'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Progress', ['action' => 'progress'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Meter', ['action' => 'meter'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Timeline', ['action' => 'timeline'], ['class' => 'nav-link'])?></li>
</ul>
