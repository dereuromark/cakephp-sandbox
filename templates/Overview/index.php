<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h2>Welcome</h2>
<p>This is a private website contributing to CakePHP.
I always found it difficult so "imagine" specific code snippets without demo/examples.
This site combines useful code snippets with their live result.
</p>

<div class="row">
	<div class="col-sm-6">
		<h3>Conventions &amp; help for CakePHP Newbies</h3>
		<ul>
			<li><?php echo $this->Html->link('Discover CakePHP Conventions', ['plugin' => 'Sandbox', 'controller' => 'Conventions', 'action' => 'index']); ?></li>
			<li><?php echo $this->Html->link('Beginner tips', ['plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'beginner-tips']); ?></li>
			<li><?php echo $this->Html->link('Best practice', ['plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'best-practices']); ?></li>
		</ul>
	</div>

	<div class="col-sm-6">
		<h3>Super useful helpers</h3>

		<ul>
			<li><?php echo $this->Html->link('The CakePHP Inflector at work', ['plugin' => 'Sandbox', 'controller' => 'Inflector', 'action' => 'index']); ?></li>
			<li>
				Check out the
				<a href="https://github.com/dereuromark/executionorder" target="_blank">Execution order application</a> to show all events in CakePHP and in what order they execute/fire.</li>

		</ul>

	</div>

</div>

<div class="row">
	<div class="col-sm-6">
		<h3>Sandbox</h3>
		Play around with demos and see some core and plugin tools in action:
		<ul>
			<li><?php echo $this->Html->link('Sandbox', ['plugin' => 'Sandbox', 'controller' => 'Sandbox', 'action' => 'index']); ?></li>
			<li><?php echo $this->Html->link('Auth Sandbox', ['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']); ?></li>
		</ul>
	</div>

	<div class="col-sm-6">

		<h3>Shared Standard data</h3>
		ISO and other commonly used data:
		<ul>
			<li><?php echo $this->Html->link('Standard Data', ['plugin' => false, 'controller' => 'Export', 'action' => 'index']); ?></li>
		</ul>
		You may also contribute back by adding/editing data.

	</div>

</div>


<hr />

<h3><?php echo __('Join in!') ?></h3>
There are lots of things that can be done - even for beginners. <?php echo $this->Html->link('Details', ['controller' => 'Pages', 'action' => 'display', 'contribute']);
