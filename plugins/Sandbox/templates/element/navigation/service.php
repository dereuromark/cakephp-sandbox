<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>CakePHP Service Layer</h2>
<p>
	<a href="https://github.com/burzum/cakephp-service-layer" target="_blank">[CakeServiceLayer Plugin]</a>
</p>
<p>
	If you don't want to stuff business logic in unrelated (ORM Model layer) Table classes, then Service classes are the way to go.
	They internally can use <code>ModelAwareTrait</code> and still access the Model layer where needed.
	But this way the business logic is more cleanly encapsulated.
</p>

<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('CakeServiceLayer Examples') ?></li>
	<li><?php echo $this->Navigation->link('Index', ['action' => 'index'])?></li>

	<li><?php echo $this->Navigation->link('Demo Post Service', ['action' => 'posts'])?></li>
</ul>
