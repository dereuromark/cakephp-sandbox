<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h2>Reactions Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-reactions" target="_blank" rel="noopener">[Reactions Plugin]</a>
</p>

<h3>"Reactions"</h3>
<p>lets people attach multiple GitHub-style reactions (👍 🎉 🚀 …) per record. Make any model reactable in minutes!</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="nav-item"><?php echo $this->Navigation->link('Overview', ['action' => 'index'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Behavior API', ['action' => 'api'], ['class' => 'nav-link']); ?></li>
</ul>
