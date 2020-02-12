<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Bootstrap Plugin Examples</h2>
<p>
	<a href="https://github.com/FriendsOfCake/bootstrap-ui" target="_blank">[BootstrapUi Plugin]</a>
</p>

<h3>Bootstrap V3</h3>

<?php echo $this->element('Sandbox.actions'); ?>

<h3>Bootstrap V4 (experimental!)</h3>

<?php echo $this->element('Sandbox.actions', ['arguments' => ['assets' => 'bootstrap-alpha']]);
