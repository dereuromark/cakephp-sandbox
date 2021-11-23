<?php
/**
 * @var \App\View\AppView $this
 */
?>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li><?= $this->Html->link(__('Demo Overview'), ['action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Register'), ['action' => 'register']) ?></li>
	<li><?= $this->Html->link(__('Process overview'), ['action' => 'process']) ?></li>
	<li><?= $this->Html->link(__('Moderator Panel'), ['action' => 'moderatorPanel']) ?></li>
	<li><?= $this->Html->link(__('Admin Panel'), ['action' => 'adminPanel']) ?></li>
	<li><?= $this->Html->link(__('Registration backend'), ['controller' => 'Registrations', 'action' => 'index']) ?></li>
</ul>
