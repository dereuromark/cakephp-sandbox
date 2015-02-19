<h2>Auth Sandbox</h2>
For <?php echo $this->Html->link('TinyAuth', 'https://github.com/dereuromark/cakephp-tinyauth'); ?> CakePHP authorization plugin.

<h3>Status</h3>
<?php
$status = ' a guest';
if ($this->request->session()->read('Auth.User.id')) {
    $status = ' logged in as <b>' . $this->request->session()->read('Auth.User.username') . '</b>';
}

?>
<p>
    You are <?php echo $status; ?>.
</p>
<?php if (!$this->request->session()->read('Auth.User.id')) { ?>
<?php echo $this->Html->link('Log in', ['action' => 'login']); ?>
<?php } ?>
<?php if ($this->request->session()->read('Auth.User.id')) { ?>
<?php echo $this->Html->link('Log out', ['action' => 'logout']); ?>
<?php } ?>

<h3>Access overview</h3>
Authentication is provided by a basic Form adapter.
<ul>
    <li><?php echo $this->Html->link('index', ['action' => 'index']); ?>: public</li>
    <li><?php echo $this->Html->link('for_all', ['action' => 'for_all']); ?>: for all who are logged in</li>
    <li><?php echo $this->Html->link('for_mods', ['action' => 'for_mods']); ?>: for all moderators</li>
    <li></li>
</ul>

<h3>Roles and access data</h3>
<ul>
    <li>user: user, pwd: 123</li>
    <li>user: mod, pwd: 123</li>
    <li>user: admin, pwd: 123</li>
</ul>

<h3>Notes</h3>
<ul>
<li>You can easily also use multi-role auth here (to allow users to have multiple roles at once).</li>
</ul>
