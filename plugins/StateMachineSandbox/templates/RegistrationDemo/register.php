<?php
/**
 * @var \App\View\AppView $this
 * @var \StateMachineSandbox\Model\Entity\Registration $registration
 * @var array<string> $users
 */

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/registration'); ?>
</nav>
<div class="col-12 col-sm-8">
	<h2>Register</h2>
	<p>Explanation: A user needs approval in our demo, a mod registration directly continues.</p>

	<?php echo $this->Form->create($registration);?>

	<?php echo $this->Form->control('user_id', ['label' => 'Who are you?']);?>
	<?php echo $this->Form->button(__('Let\'s do this'), ['class' => 'btn btn-primary']);?>

	<?php echo $this->Form->end(); ?>

	<br>

	<p>This will start a new state machine process for this created "registration" element/entity.</p>

	<p>You can start the demo only once per user, afterwards you need to clear/remove the registration if you want to rerun</p>

</div>
