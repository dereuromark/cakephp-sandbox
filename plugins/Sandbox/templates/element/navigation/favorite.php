<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Favorites Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-favorites" target="_blank">[Favorites Plugin]</a>
</p>

<h3>"Favorites"</h3>
<p>lets people express how they feel about some content. Make any model reactable in minutes!</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Overview', ['action' => 'index'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Star', ['action' => 'star'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Like', ['action' => 'like'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Favorite', ['action' => 'favorite'], ['class' => 'nav-link'])?></li>
</ul>
