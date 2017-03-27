<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="index">
<h2>Cache Plugin examples / showcase</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-cache" target="_blank">[Cache Plugin]</a>
</p>

<h3>Examples</h3>
<?php echo $this->element('Sandbox.actions'); ?>

<h3>Example with extension</h3>
<ul>
	<li><?php echo $this->Html->link('JSON file', ['action' => 'someJson', '_ext' => 'json']); ?></li>
</ul>

</div>
