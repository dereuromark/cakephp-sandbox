<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Queue Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-queue" target="_blank">[Queue Plugin]</a>
</p>

<h3>Background Processing in CakePHP</h3>
<p>Using the queue and cronjob functionality you can easily offload some longer running tasks into a background process.</p>

<ul class="side-nav nav nav-pills nav-stacked">
	<li class="heading"><?= __('') ?></li>
	<li><?php echo $this->Navigation->link('Basic Usage', ['action' => 'index'])?></li>
	<li><?php echo $this->Navigation->link('Scheduling', ['action' => 'scheduling'])?></li>
</ul>
