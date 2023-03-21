<?php
/**
 * @var \App\View\AppView $this
 */

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/registration'); ?>
</nav>
<div class="col-12 col-sm-8">
	<h1>Workflow</h1>
	<ul>
		<li>A user wants to sign up for a workshop/event</li>
		<li>Once registered, he needs to pay his ticket and is then approved for the workshop</li>
		<li>A confirmation mail is sent with details</li>
	</ul>

	<h2>Implementation</h2>
	<p>We "simulate" the payment gateway here, of course</p>
	<ul>
		<li>We have synchronous triggers (user on site sends registration form)</li>
		<li>There are also async triggers, e.g. status update from payment provider</li>
		<li>We also trigger async events and queue jobs, e.g. for sending emails</li>
	</ul>


	<h2>Let's try it</h2>
	<p>
		<?php echo $this->Html->linkFromPath('Register for the event', 'StateMachineSandbox.RegistrationDemo::register', [], ['class' => 'btn btn-secondary']); ?>
	</p>

	<h2>Graph</h2>
	<p>The following is a live graph of the workflow implementation (rendered fresh from config):</p>
	<?php
	$stateMachine = \StateMachineSandbox\StateMachine\RegistrationStateMachineHandler::NAME;
	$process = \StateMachineSandbox\StateMachine\RegistrationStateMachineHandler::NAME . '01';
	$url = ['prefix' => 'Admin', 'plugin' => 'StateMachine', 'controller' => 'Graph', 'action' => 'draw', '?' => ['state-machine' => $stateMachine, 'process' => $process]];
	$image = $this->Html->image($url);
	echo $image;
	//echo $this->Html->link($image, $url, ['escape' => false, 'target' => '_blank']);
	?>

	<p>A real life example can often be 10-20x larger in complexity.</p>

	<h2>Code behind it</h2>
	<p>
		The state machine above is written in <a href="https://github.com/dereuromark/cakephp-sandbox/blob/master/plugins/StateMachineSandbox/config/StateMachines/Registration/Registration01.xml" target="_blank">XML</a>.
		It also shows the commands and conditions that directly link to <a href="https://github.com/dereuromark/cakephp-sandbox/tree/master/plugins/StateMachineSandbox/src/StateMachine" target="_blank">PHP code</a>.
	</p>

</div>
