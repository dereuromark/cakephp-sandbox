<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Flash Messages</h2>
<?php
foreach ($types as $type) {
	echo $this->Html->link($type, ['action' => 'flash', $type], ['class' => 'btn btn-default']) . ' ';
}

echo $this->Html->link('HTML', ['action' => 'flash', 'html'], ['class' => 'btn btn-default']) . ' ';
?>

<br><br>
<p>Note that multi (stackable) messages are only supported in CakePHP 3.1+ or using the Flash Plugin functionality.</p>
