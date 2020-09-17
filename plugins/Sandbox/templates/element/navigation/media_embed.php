<?php
/**
 * @var \App\View\AppView $this
 */
?>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('MediaEmbed') ?></li>
	<li><?php echo $this->Navigation->link('Parsing', ['action' => 'index'])?></li>
	<li><?php echo $this->Navigation->link('BBCode Example', ['action' => 'bbcode'])?></li>
	<li><?php echo $this->Navigation->link('Supported Sites', ['action' => 'hosts'])?></li>
</ul>
