<h2>Auth Sandbox</h2>
For <?php echo $this->Html->link('TinyAuth', 'https://github.com/dereuromark/cakephp-tinyauth'); ?> CakePHP authorization plugin.

<h3>Login</h3>
<?php echo $this->Form->create();?>
<p>Please enter your username/email and password below.</p>

<?php
echo $this->Form->input('login', array('label' => 'Your username or email'));
echo $this->Form->input('password', array('autocomplete' => 'off'));
?>
<?php echo $this->Form->submit(__('Log me in'));?>
<?php echo $this->Form->end(); ?>


<h3>Roles and access data</h3>
<ul>
    <li>user: user, pwd: 123</li>
    <li>user: mod, pwd: 123</li>
    <li>user: admin, pwd: 123</li>
</ul>
