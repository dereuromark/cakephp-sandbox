<?php
/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob[] $queuedJobs
 */
?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

<h3>Basic Usage</h3>
	<p>The most common use cases are usually</p>
	<ul>
		<li>Incoming JSON/Array data (unstructured)</li>
		<li>Entity-less speaking objects (non ORM related)</li>
	</ul>

	<p>See <a href="https://github.com/dereuromark/cakephp-dto/blob/master/docs/Examples.md" target="_blank">this</a> for some basic examples.</p>

</div>
