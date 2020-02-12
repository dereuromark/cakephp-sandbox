<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<h3><?php echo __('Step 3: Set a new password')?></h3>

<div class="users form">
<?php echo $this->Form->create($user);?>
	<fieldset>
		<legend><?php echo __('Enter your new password and confirm it');?></legend>
	<?php
		echo $this->Form->control('pwd', ['type' => 'password', 'autocomplete' => 'off']);
		echo $this->Form->control('pwd_repeat', ['type' => 'password', 'autocomplete' => 'off']);
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li>I do remember again. <?php echo $this->Html->link(__('Abort'), ['action' => 'lost_password', '?' => ['abort' => 1]], ['confirm' => __('Sure?')]);?></li>
		<li><?php echo $this->Html->link(__('Login instead'), ['action' => 'login']);?></li>
	</ul>
</div>
