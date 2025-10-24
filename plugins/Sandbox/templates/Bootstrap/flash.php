<?php
/**
 * @var \App\View\AppView $this
 * @var string[] $types
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/bootstrap'); ?>
</nav>
<div class="page flash col-sm-8 col-12">

<h3>Flash Messages</h3>
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
