<h2>AJAX Examples</h2>
<a href="https://github.com/dereuromark/cakephp-ajax" target="_blank">[Source]</a>

<h3>Using CakePHP Core only</h3>
<ul>
	<li><?php echo $this->Html->link('Simple JSON response', array('action' => 'simple'))?></li>
	<li><?php echo $this->Html->link('Toggle', array('action' => 'toggle'))?></li>
	<li><?php echo $this->Html->link('Pagination', array('action' => 'pagination'))?></li>
	<li><?php echo $this->Html->link('Redirecting', array('action' => 'redirecting'))?></li>
</ul>

<h3>Using Ajax Plugin</h3>
<ul>
	<li><?php echo $this->Html->link('Chained dropdowns', array('action' => 'chained_dropdowns'))?></li>
	<li><?php echo $this->Html->link('Redirecting (prevented)', array('action' => 'redirecting_prevented'))?></li>
</ul>