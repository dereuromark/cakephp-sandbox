<h2><?php echo h($this->Session->read('Auth.User.username'));?></h2>
Your eMail: <?php echo h($this->Session->read('Auth.User.email'));?>
<br /><br />

<h3>Your account</h3>
<ul>
<li><?php echo $this->Html->link(__('Edit'), ['plugin' => false, 'admin' => false, 'action' => 'edit']); ?></li>
</ul>

<?php
//pr ($info);
