<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h2>Mercure Examples</h2>
<p>
	<a href="https://github.com/josbeir/cakephp-mercure" target="_blank">[Mercure Plugin]</a>
</p>

<h3>Real-Time Updates</h3>
<p>Using Mercure protocol with Server-Sent Events for push notifications to connected clients.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Overview', ['action' => 'index'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Chat Demo', ['action' => 'chat'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Queue Integration', ['action' => 'queueProgress'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Publishing', ['action' => 'publishing'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Subscription', ['action' => 'subscription'], ['class' => 'nav-link']); ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Authorization', ['action' => 'authorization'], ['class' => 'nav-link']); ?></li>
</ul>
