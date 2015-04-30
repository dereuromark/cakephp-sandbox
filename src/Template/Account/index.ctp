<h2>Your account</h2>

Logged in as <b><?php echo h($this->request->session()->read('Auth.User.username')); ?></b>

<?php if (false) { ?>
<ul>
<li><?php //echo $this->Html->link(__('Edit'), ['plugin' => false, 'admin' => false, 'action' => 'edit']); ?></li>
</ul>
<?php } ?>

<?php
