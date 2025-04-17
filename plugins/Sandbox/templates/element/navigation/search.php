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
	<li><?php echo $this->Navigation->link('Simple overview form', ['action' => 'index'])?></li>
	<li><?php echo $this->Navigation->link('Table search form', ['action' => 'table'])?></li>
	<li><?php echo $this->Navigation->link('Range search widget', ['action' => 'range'])?></li>
</ul>
