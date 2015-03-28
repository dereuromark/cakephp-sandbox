<h2>Sandbox</h2>

<h3>Available actions</h3>
<ul>
<?php foreach ($methods as $method) { ?>
	<li><?php echo $this->Html->link(Inflector::humanize($method), ['admin' => null, 'action' => $method]); ?></li>
<?php } ?>
</ul>