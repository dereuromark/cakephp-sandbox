<ul>
<?php foreach ($actions as $action) { ?>
	<li><?php echo $this->Html->link(Inflector::humanize($action), array('action' => $action)); ?></li>
<?php } ?>
</ul>