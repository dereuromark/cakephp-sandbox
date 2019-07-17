<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>AJAX Examples</h2>
<a href="https://github.com/dereuromark/cakephp-ajax" target="_blank">[Source]</a>

<h3>Using CakePHP Core only</h3>
<ul>
	<li><?php echo $this->Html->link('Simple JSON response', ['action' => 'simple'])?></li>
	<li><?php echo $this->Html->link('Pagination', ['action' => 'pagination'])?></li>
	<li><?php echo $this->Html->link('Endless scroll (vertical pagination)', ['action' => 'endlessScroll'])?></li>
	<li><?php echo $this->Html->link('Redirecting', ['action' => 'redirecting'])?></li>
</ul>

<h3>Using Ajax Plugin</h3>
<ul>
	<li><?php echo $this->Html->link('Toggle', ['action' => 'toggle'])?></li>
	<li><?php echo $this->Html->link('Buttons/Delete', ['action' => 'table'])?></li>
	<li><?php echo $this->Html->link('Forms', ['action' => 'form'])?></li>
	<li><?php echo $this->Html->link('Chained dropdowns', ['action' => 'chained_dropdowns'])?></li>
	<li><?php echo $this->Html->link('Redirecting (prevented)', ['action' => 'redirecting_prevented'])?></li>
</ul>
