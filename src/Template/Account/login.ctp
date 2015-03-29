<h2>Welcome</h2>
<p>You need to login to proceed.</p>

<?php echo $this->Form->create('User');?>

<h3>Please enter your username/email and password below.</h3>

	<?php
		echo $this->Form->input('login', ['label' => 'Your username or email']);
		echo $this->Form->input('password', ['autocomplete' => 'off']);
		if (Configure::read('Config.rememberMe')) {
			echo $this->Form->input('RememberMe.confirm', ['type' => 'checkbox', 'label' => __('Remember me on this device.')]);
		}
	?>

<?php echo $this->Form->submit(__('Log me in')); echo $this->Form->end();?>

<h3>No account yet?</h3>
<?php if (Configure::read('Config.allowRegister')) { ?>
	<p><?php echo $this->Html->link('Create one here. For free :P', ['action' => 'register'])?></p>
<?php } else { ?>
	<p><?php echo __('Note'); ?>: <?php echo __('Currenctly the backend is for the admin only - but it will soon be available for public contributors')?></p>
<?php } ?>

<h3>Password lost?</h3>
<p><?php echo $this->Html->link('Reset your password.', ['action' => 'lost_password'])?></p>

