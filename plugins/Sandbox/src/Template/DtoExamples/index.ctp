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
		<li>Email sending (because of gateway timeouts)</li>
		<li>Video/image processing (because of memory/timeout issues)</li>
		<li>Invoice/PDF/zipfile generation (because of timeout issues)</li>
	</ul>
	<p>You don't want the browser to reload forever and eventually the request to die. Instead, you want to quickly give feedback of the task being started and then just inform them again once the job is done.</p>


</div>
