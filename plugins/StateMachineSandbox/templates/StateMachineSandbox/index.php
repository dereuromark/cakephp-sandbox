<?php
/**
 * @var \App\View\AppView $this
 */

?>

<h1>State Machines in (Cake)PHP</h1>

<p>
	Using the Spryker <a href="https://github.com/spryker/cakephp-statemachine" target="_blank">StateMachine plugin</a>.
</p>

<div class="row">
	<div class="col-12">
		<h2>Workflow</h2>
		<p>A classical example is a workflow:</p>
		<ul>
			<li>Order Management (Checkout, Payment, Delivery, Refund)</li>
			<li>Multi-step registration processes</li>
			<li>Complex processes for clear human interaction</li>
		</ul>


		<h2>Automation</h2>
		<p>Another common use case is automation of existing processes. This can be partially or in some cases even fully:</p>
		<ul>
			<li>Release Process</li>
			<li>Multi-Step Validation through tooling</li>
			<li>Repeating chain of tasks</li>
		</ul>

		<h2>Demo</h2>
		<?php echo $this->Html->linkFromPath('Event-Registration', 'StateMachineSandbox.RegistrationDemo::index'); ?>

	</div>

</div>
