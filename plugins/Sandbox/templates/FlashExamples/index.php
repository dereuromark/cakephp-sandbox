<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="index">
<h2>Flash Plugin examples / showcase</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-flash" target="_blank">[Flash Plugin]</a>
</p>

<h3>Examples</h3>

<ul>
	<li><?php echo $this->Html->link('All flash message types', ['action' => 'messages']); ?></li>
	<li><?php echo $this->Html->link('Grouped types', ['action' => 'messageGroups']); ?></li>
</ul>


<h3>Example with AJAX</h3>
<ul>
	<li><?php echo $this->Html->link('AJAX Buttons', ['action' => 'ajax']); ?></li>
	<li><?php echo $this->Html->link('AJAX Buttons with Ajax Plugin', ['action' => 'ajaxPlugin']); ?></li>
	<li><?php echo $this->Html->link('AJAX Forms with Ajax Plugin', ['controller' => 'AjaxExamples', 'action' => 'form']); ?></li>
</ul>

</div>
