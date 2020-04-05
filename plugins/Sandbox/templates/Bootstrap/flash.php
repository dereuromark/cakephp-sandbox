<?php
/**
 * @var \App\View\AppView $this
 * @var string[] $types
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
<p>Note that multi (stackable) messages are supported, if you need more flexibility check out the <a href="https://github.com/dereuromark/cakephp-flash" target="_blank">Flash plugin</a>.</p>
