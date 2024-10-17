<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\StateMachineSandbox\Model\Entity\Registration> $registrations
 * @var array $queuedJobs
 * @var array $timeouts
 */

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/registration'); ?>
</nav>
<div class="col-12 col-sm-8">
	<h1>Admin Panel</h1>
	<p>Here you can manually invoke certain events where needed or remove registrations.</p>
	<p>Note: The payment confirmation gets triggered via background job 1 min after the request. If you don't want to wait that long, you can press the blue button beforehand to manually invoke this event.</p>

	<?php if (!empty($timeouts)) { ?>
		<h2><?php echo count($timeouts) ?> timeout(s) running</h2>
		<ul>
			<?php foreach ($timeouts as $timeout) { ?>
				<li>
					RG <?php echo h($timeout->identifier); ?>: <?php echo h($timeout->event); ?> (<?php echo $this->Time ->nice($timeout->timeout); ?>)
					<div>
						<small>
							Supposed to execute: <?php echo $this->Time->relLengthOfTime($timeout->timeout); ?>
						</small>
					</div>
				</li>
			<?php } ?>
		</ul>

	<?php } ?>

	<?php if (!empty($queuedJobs)) { ?>
		<h2><?php echo count($queuedJobs) ?> job(s) running</h2>
		<ul>
			<?php foreach ($queuedJobs as $queuedJob) { ?>
				<li>
					<?php echo h($queuedJob->job_task); ?>
					:
					<?php
					$status = $queuedJob->fetched ? 'running' : 'queued';
					if ($queuedJob->failure_message) {
						$status = '<span style="color: red">errored</span>';
					}
					echo $status;
					?>
					(<?php echo $queuedJob->fetched ? 'started ' . $this->Time->nice($queuedJob->fetched) : 'not started'; ?>)

					<?php if (!$queuedJob->fetched && $queuedJob->notbefore) {
						echo '<br>Delay: ' . $this->QueueProgress->timeoutProgressBar($queuedJob, 8);
					} ?>

					<?php if ($queuedJob->notbefore && $queuedJob->notbefore->isFuture()) {
						echo '<div><small>';
						echo $this->Time->relLengthOfTime($queuedJob->notbefore);
						echo '</small></div>';
					} ?>

					<?php if ($queuedJob->fetched && !$queuedJob->failed && !$queuedJob->failure_message) {
						echo '<br>' . $this->QueueProgress->progressBar($queuedJob, 18);
					} ?>

					<?php if ($queuedJob->failed) {
						echo '<div class="error inline-message">Failed! ' . $this->Queue->failureStatus($queuedJob) . '.<br>' . h($this->Text->truncate($queuedJob->failure_message, 200)) . '';

						echo '<div>' . $this->Form->postLink('Remove', ['action' => 'removeJob', $queuedJob->id]) . '</div>';
					} ?>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>

	<h2>Registrations</h2>
	<?php foreach ($registrations as $registration) { ?>

		<h3>Registration for `<?php echo h($registration->user->username); ?>`</h3>
		<ul>
			<li>Registration status: <b><?php echo h($registration->status); ?></b></li>
			<li>Detailed state (internal): `<?php echo h($registration->registration_state->state) ;?>`</li>
		</ul>

		<?php if ($registration->registration_state->state === \StateMachineSandbox\StateMachine\RegistrationStateMachineHandler::STATE_WAITING_FOR_PAYMENT) { ?>
			<p><?php echo $this->Form->postLink('Confirm payment', [$registration->id], ['class' => 'btn btn-primary']); ?> (manual confirmation if needed)</p>
		<?php } ?>

		<p><?php echo $this->Form->postLink('Remove', ['controller' => 'Registrations', 'action' => 'delete', $registration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registration->id), 'class' => 'btn btn-danger']); ?> (demo only)</p>

	<?php } ?>

	<h2>Logs</h2>
	<p>Every single transition (or try thereof) is logged. For simplicity those are now not shown here.</p>

	<h2>Background processing</h2>
	<p>
	In the background crontab is triggering the state machine conditions and timeouts every minute:
	</p>
	<code><pre>* * * * * cd /sandbox && bin/cake state_machine check_conditions Registration -q
* * * * * cd /sandbox && bin/cake state_machine check_timeouts Registration -q</pre></code>
</div>
