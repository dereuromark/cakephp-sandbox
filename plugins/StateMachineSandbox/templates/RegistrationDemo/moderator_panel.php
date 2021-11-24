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
	<h1>Approve guest registrations</h1>
	<p>All non-moderator registrations require approval by a moderator in our demo.</p>

	<h2>Registrations</h2>
	<?php foreach ($registrations as $registration) { ?>

		<h3>Registration for `<?php echo h($registration->user->username); ?>`</h3>
		<ul>
			<li>Registration status: <b><?php echo h($registration->status); ?></b></li>
			<li>Detailed state (internal): `<?php echo h($registration->registration_state->state) ;?>`</li>
			<?php if ($registration->registration_state->state === \StateMachineSandbox\StateMachine\RegistrationStateMachineHandler::STATE_WAITING_FOR_APPROVAL) { ?>
				<li><?php echo $this->Form->postLink('Approve', [$registration->id], ['class' => 'btn btn-success']); ?></li>
			<?php } ?>
		</ul>

	<?php } ?>
</div>
