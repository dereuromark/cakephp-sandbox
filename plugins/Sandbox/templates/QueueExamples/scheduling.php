<?php
/**
 * @var \App\View\AppView $this
 * @var \Queue\Model\Entity\QueuedJob[] $queuedJobs
 * @var \Queue\Model\Entity\QueuedJob $queuedJob
 * @var string[] $tasks
 */

$this->loadHelper('Queue.QueueProgress');
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/queue'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Scheduling</h3>
	<p>Sometimes you also want to trigger something with a bit of delay</p>
	<ul>
		<li>Email sending with the option of "cancelling" within 1-2 minutes.</li>
		<li>Offloading some high traffic tasks into the night.</li>
	</ul>

	<h4>Give it a try</h4>

	<?php echo $this->Form->create($queuedJob);?>
	<fieldset>
		<legend><?php echo __('Select a task to run'); ?></legend>
		<?php
		echo $this->Form->control('job_task', ['options' => $tasks]);

		echo '<p>Current (server) time: ' . (new \Cake\I18n\DateTime()) . '</>';

		echo $this->Form->control('notbefore', ['type' => 'text', 'default' => (new \Cake\I18n\DateTime())->addMinutes(5)]);

		?>
	</fieldset>
	<?php echo $this->Form->submit(__('Submit')); ?>
	<?php echo $this->Form->end();?>


	<?php if ($queuedJobs) { ?>
		<h4>Currently running: </h4>
		<ul>
			<?php foreach ($queuedJobs as $queuedJob) { ?>
				<li>
					<b><?php echo h($queuedJob->job_task); ?></b>: scheduled to start at <?php echo $this->Time->nice($queuedJob->notbefore); ?>
					<?php if (!$queuedJob->fetched) {
						echo $this->Form->postLink($this->Icon->render('times', ['title' => 'Cancel (if not yet started)']), ['action' => 'cancelJob', $queuedJob->id], ['escape' => false, 'confirm' => 'Sure?']);
					} ?>
					<?php if (!$queuedJob->fetched) {
						echo '<br>';
						echo 'Scheduling progress (until job starts): ' . $this->QueueProgress->htmlTimeoutProgressBar($queuedJob, $this->QueueProgress->timeoutProgressBar($queuedJob, 20));
					} else { ?>
						<div>
						<?php echo $this->Number->toPercentage($queuedJob->progress * 100, 0); ?> (Status: <code><?php echo h($queuedJob->status) ?: 'n/a'; ?></code>)
						<br>
						<?php echo $this->QueueProgress->htmlProgressBar($queuedJob, $this->QueueProgress->progressBar($queuedJob, 30)); ?>
						<div>
					<?php } ?>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>

</div>
