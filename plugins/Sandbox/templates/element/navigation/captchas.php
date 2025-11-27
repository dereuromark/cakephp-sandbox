<?php
/**
 * @var \App\View\AppView $this
 */
?>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Captcha') ?></li>
	<li><?= $this->Navigation->link('Overview', ['action' => 'index']) ?></li>
	<li><?= $this->Navigation->link('Math Captcha', ['action' => 'math']) ?></li>
	<li><?= $this->Navigation->link('Passive Captcha', ['action' => 'modelLess']) ?></li>
	<li class="heading"><?= __('Links') ?></li>
	<li class="nav-item"><?= $this->Html->link('Plugin on GitHub', 'https://github.com/dereuromark/cakephp-captcha', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
</ul>
