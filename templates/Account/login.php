<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">

	<div class="col-xs-12">

<h2>Welcome</h2>
<p>You need to login to proceed.</p>

<?php echo $this->Form->create();?>

<h3>Please enter your username/email and password below.</h3>

	<?php
		echo $this->Form->control('login', ['label' => 'Your username or email']);
		echo $this->Form->control('password', ['autocomplete' => 'off']);
		if ($this->Configure->read('Config.rememberMe')) {
			echo $this->Form->control('RememberMe.confirm', ['type' => 'checkbox', 'label' => __('Remember me on this device.')]);
		}
	?>

<?php echo $this->Form->submit(__('Log me in')); echo $this->Form->end();?>

		<?php if (false) { ?>
<div class="row">
	<div class="col-sm-6 col-xs-12">
		<h3>No account yet?</h3>
		<?php if ($this->Configure->read('Config.allowRegister')) { ?>
			<p><?php echo $this->Html->link('Create one here. For free :P', ['action' => 'register'])?></p>
		<?php } else { ?>
			<p><?php echo __('Note'); ?>: <?php echo __('Currenctly the backend is for the admin only - but it will soon be available for public contributors')?></p>
		<?php } ?>
	</div>
	<div class="col-sm-6 col-xs-12">
		<h3>Password lost?</h3>
		<p><?php echo $this->Html->link('Reset your password.', ['action' => 'lost_password'])?></p>
	</div>
</div>
		<?php } ?>

	</div>

</div>
