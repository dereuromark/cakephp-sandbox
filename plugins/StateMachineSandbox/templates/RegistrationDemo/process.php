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
	<h2>Process</h2>

	<?php foreach ($registrations as $registration) { ?>

	<h3>Registration for `<?php echo h($registration->user->username); ?>`</h3>
	<ul>
		<li>Registration status: <b><?php echo h($registration->status); ?></b></li>
		<li>Detailed state (internal): `<?php echo h($registration->registration_state->state) ;?>`</li>
	</ul>
	<?php
	$stateMachine = \StateMachineSandbox\StateMachine\RegistrationStateMachineHandler::NAME;
	$process = \StateMachineSandbox\StateMachine\RegistrationStateMachineHandler::NAME . '01';
	$url = ['prefix' => 'Admin', 'plugin' => 'StateMachine', 'controller' => 'Graph', 'action' => 'draw', '?' => ['state-machine' => $stateMachine, 'process' => $process, 'highlight-state' => $registration->registration_state->state]];
	$image = $this->Html->image($url);
	echo $image;
	//echo $this->Html->link($image, $url, ['escape' => false, 'target' => '_blank']);
	?>
	<?php } ?>

</div>
