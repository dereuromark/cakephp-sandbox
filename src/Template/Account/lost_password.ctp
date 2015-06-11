
<h2><?php echo __('Password lost?');?></h2>

<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset id="step-1">
		<legend><?php echo __('Step {0}', 1);?></legend>
		<p>Please enter your email address</p>
	<?php
	echo $this->Form->input('Form.login', ['autocomplete' => 'off', 'label' => __('Email')]);
	echo $this->Captcha->input();

	echo $this->Form->submit(__('Submit'));
	?>
	</fieldset>
<?php echo $this->Form->end();?>
<br/>
<?php echo $this->Form->create('User');?>
	<fieldset id="step-2">
 		<legend><?php echo __('Step {0}', 2);?></legend>
 		<p>
			Click on the link in the email or Copy-and-Paste your received token here:
 		</p>
	<?php
	echo $this->Form->input('Form.key', ['autocomplete' => 'off']);

	echo $this->Form->submit(__('Submit'));
	?>
	</fieldset>
<?php echo $this->Form->end();?>
</div>


<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Login instead'), ['action' => 'login']);?></li>
	</ul>
</div>