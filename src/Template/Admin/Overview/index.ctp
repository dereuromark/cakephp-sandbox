<h2>Admin Backend</h2>

<h3>Management</h3>
<ul>
	<li><?php echo $this->Html->link(__('Users'), ['prefix' => 'admin', 'controller' => 'Users'])?></li>
</ul>

<h3>System</h3>
<ul>
	<li><?php echo $this->Html->link(__('Logs'), ['prefix' => 'admin', 'plugin' => 'DatabaseLog', 'controller' => 'Logs'])?></li>
</ul>
