<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Search plugin</h2>
<p>
	<a href="https://github.com/FriendsOfCake/search" target="_blank">[Search Plugin]</a>
</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Search handling in CakePHP') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Simple overview form', ['action' => 'index'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Table search form', ['action' => 'table'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Range search widget', ['action' => 'range'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Dealing with empty values', ['action' => 'emptyValues'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Form validation', ['action' => 'validation'], ['class' => 'nav-link'])?></li>
</ul>
