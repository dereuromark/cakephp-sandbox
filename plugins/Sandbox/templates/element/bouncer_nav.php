<?php
/**
 * Bouncer Examples Navigation
 *
 * @var \App\View\AppView $this
 */
$current = $this->request->getParam('action');
?>

<nav class="mb-4">
	<ul class="nav nav-pills">
		<li class="nav-item">
			<?= $this->Html->link(
				'Overview',
				['action' => 'index'],
				['class' => 'nav-link' . ($current === 'index' ? ' active' : '')]
			) ?>
		</li>
		<li class="nav-item">
			<?= $this->Html->link(
				'Articles',
				['action' => 'articles'],
				['class' => 'nav-link' . ($current === 'articles' ? ' active' : '')]
			) ?>
		</li>
		<li class="nav-item">
			<?= $this->Html->link(
				'Submit Article',
				['action' => 'add'],
				['class' => 'nav-link' . ($current === 'add' ? ' active' : '')]
			) ?>
		</li>
		<li class="nav-item">
			<?= $this->Html->link(
				'Pending Queue',
				['action' => 'pending'],
				['class' => 'nav-link' . (in_array($current, ['pending', 'review']) ? ' active' : '')]
			) ?>
		</li>
		<li class="nav-item">
			<?= $this->Html->link(
				'Admin Bypass',
				['action' => 'adminAdd'],
				['class' => 'nav-link' . ($current === 'adminAdd' ? ' active' : '')]
			) ?>
		</li>
	</ul>
</nav>
