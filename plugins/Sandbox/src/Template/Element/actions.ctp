<ul>
<?php foreach ($actions as $action) { ?>
	<li><?php echo $this->Html->link(\Cake\Utility\Inflector::humanize($action), ['action' => $action]); ?></li>
<?php } ?>
</ul>