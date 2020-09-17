<?php
/**
 * @var \App\View\AppView $this
 * @var string[] $types
 */
?>

<div class="row">
	<div class="col-md-12">

<h2>Flash Messages</h2>
<?php
foreach ($types as $type) {
	echo $this->Html->link($type, ['action' => 'flash', $type], ['class' => 'btn btn-secondary']) . ' ';
}

echo $this->Html->link('HTML', ['action' => 'flash', 'html'], ['class' => 'btn btn-secondary']) . ' ';
?>

<br><br>
<p>Note that multi (stackable) messages are supported, if you need more flexibility check out the <a href="https://github.com/dereuromark/cakephp-flash" target="_blank">Flash plugin</a>.</p>

	</div>
</div>
