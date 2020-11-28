<?php
/**
 * @var \App\View\AppView $this
 * @var string[] $actions
 * @var string[]|null $exclude
 */
 	if (!isset($arguments)) {
		$arguments = [];
	}
?>
<ul>
<?php foreach ($actions as $action) { ?>
	<?php
	if (!empty($exclude) && in_array($action, $exclude, true)) {
		continue;
	}
	?>
	<li><?php echo $this->Html->link(\Cake\Utility\Inflector::humanize($action), array_merge(['action' => $action], $arguments) ); ?></li>
<?php } ?>
</ul>
