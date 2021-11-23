<?php
/**
 * @var \App\View\AppView $this
 * @var \StateMachineSandbox\Model\Entity\Registration[]|\Cake\Collection\CollectionInterface $registrations
 */

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/registration'); ?>
</nav>
<div class="col-12 col-sm-8">
	<h2>Admin Panel</h2>
	<p>Here you can manually invoke certain events where needed or remove registrations.</p>
	<p>Note: The payment confirmation gets triggered via background job 1 min after the request. If you don't want to wait that long, you can press the blue button beforehand to manually invoke this event.</p>

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
</div>
