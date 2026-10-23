<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h2>Carve Plugin</h2>
<p>
	<a href="https://github.com/markup-carve/cakephp-carve" target="_blank" rel="noopener">[Carve Plugin]</a>
</p>

<p>Render, validate and store <a href="https://github.com/markup-carve/carve" target="_blank" rel="noopener">Carve</a> markup in a CakePHP app: helper, <code>.crv</code> views, validation, an ORM behavior and commands.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="nav-item"><?php echo $this->Navigation->link('Overview', ['action' => 'index'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Validation', ['action' => 'validation'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Behavior', ['action' => 'behavior'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('CarveView', ['action' => 'view'], ['class' => 'nav-link']); ?></li>
</ul>

<p class="mt-3">
	For the markup language itself, see the
	<?php echo $this->Html->link('Carve playground and examples', ['controller' => 'Carve', 'action' => 'index']); ?>.
</p>
