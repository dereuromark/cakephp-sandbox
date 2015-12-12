<?php
 	if (!isset($arguments)) {
		$arguments = [];
	}
?>
<ul>
<?php foreach ($actions as $action) { ?>
	<li><?php echo $this->Html->link(\Cake\Utility\Inflector::humanize($action), array_merge(['action' => $action], $arguments) ); ?></li>
<?php } ?>
</ul>
