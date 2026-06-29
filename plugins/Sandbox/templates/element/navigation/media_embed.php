<?php
/**
 * @var \App\View\AppView $this
 */
?>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('MediaEmbed') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Parsing', ['action' => 'index'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('BBCode Example', ['action' => 'bbcode'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Supported Sites', ['action' => 'hosts'], ['class' => 'nav-link'])?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Carve') ?></li>
	<li class="nav-item"><?php echo $this->Html->link(__('Media Embeds in Carve'), ['controller' => 'Carve', 'action' => 'mediaEmbed'], ['class' => 'nav-link']) ?></li>
</ul>
