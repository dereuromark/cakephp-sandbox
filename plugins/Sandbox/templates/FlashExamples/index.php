<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="index">
<h2>Flash Plugin examples / showcase</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-flash" target="_blank">[Flash Plugin]</a>
</p>

<h3>Examples</h3>
<?php echo $this->element('Sandbox.actions'); ?>

<h3>All flash message types</h3>
	...

<h3>Example with AJAX</h3>
<ul>
	<li><?php echo $this->Html->link('...', ['action' => 'ajax']); ?></li>
</ul>

</div>
