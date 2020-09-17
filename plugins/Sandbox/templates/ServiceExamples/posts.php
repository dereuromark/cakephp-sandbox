<?php
/**
 * @var \App\View\AppView $this
 * @var array $posts
 * @var int $result
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/service'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h2><?php echo __('Demo Service');?>: Sandbox.Calculation/Post</h2>

	<p>Data</p>
	<pre><?php echo print_r($posts, true); ?></pre>

	<p>Controller action code</p>
	<pre>$this-&gt;loadService('Sandbox.Calculator/Post');
$result = $this-&gt;Post-&gt;calculate($posts);</pre>

	<p>
		Executing <code>-&gt;calculate()</code> on that data:
<?php
echo h($result);
?>
	</p>


	<h3>IDE support</h3>
	<p>This is fully typehinted and autocompleted by the IDE if you use the shipped IdeHelper plugin enhancements.</p>

</div>
