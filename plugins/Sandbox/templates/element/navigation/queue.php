<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Queue Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-queue" target="_blank">[Queue Plugin]</a>
</p>

<h3>Background Processing</h3>
<p>Using the queue and cronjob functionality you can easily offload some longer running tasks into a background process.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Basic Usage', ['action' => 'index'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Scheduling', ['action' => 'scheduling'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Config', ['action' => 'config'], ['class' => 'nav-link'])?></li>
</ul>
