<?php
/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob[] $queuedJobs
 */
?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/queue'); ?>
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

	<h4>Give it a try</h4>
	<p>
	Let's provide a button to trigger a background job:
	</p>

	<p>
	<?php echo $this->Form->postLink('Trigger a demo task', ['action' => 'scheduleDemo'], ['class' => 'btn btn-primary']); ?>
	</p>

	<p>This job will take about 20 sek. You can monitor the progress below (you need to reload the page, browser refresh). Note that we prevent it to be run twice while still running.</p>

	<?php if ($queuedJobs) { ?>
	<h4>Currently running: </h4>
	<ul>
		<?php foreach ($queuedJobs as $queuedJob) { ?>
		<li>
			<?php echo h($queuedJob->job_type); ?>: <?php echo $this->Number->toPercentage($queuedJob->progress * 100, 0); ?> (Status: <code><?php echo h($queuedJob->status) ?: 'n/a'; ?></code>)
		</li>
		<?php } ?>
	</ul>
	<?php } ?>

</div>
