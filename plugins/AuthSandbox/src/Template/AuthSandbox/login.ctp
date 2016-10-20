<h2>Auth Sandbox</h2>
For <?php echo $this->Html->link('TinyAuth', 'https://github.com/dereuromark/cakephp-tinyauth'); ?> CakePHP authentication and authorization plugin.

<div class="row">
	<div class="col-md-6">

<h3>Login</h3>
<?php echo $this->Form->create();?>
<p>Please enter your username and password below.</p>

<?php
echo $this->Form->input('login', ['label' => 'Your username']);
echo $this->Form->input('password', ['autocomplete' => 'off']);
?>
<?php echo $this->Form->submit(__('Log me in'));?>
<?php echo $this->Form->end(); ?>
</div>
<div class="col-md-6">

	<div class="well">
	<h3>Roles and access credentials</h3>
	<ul>
		<li>not logged in (no role)</li>
		<li><span class="badge">user</span> username: user, pwd: 123</li>
		<li><span class="badge">mod</span> username: mod, pwd: 123</li>
		<li><span class="badge">admin</span> username: admin, pwd: 123</li>
	</ul>
	</div>

	<p>
		<?php echo $this->Html->link('Back', ['action' => 'index']); ?>
	</p>

</div>
</div>
