<div class="users form">
You should now recieve an email.<br />
Please click on the link to activate your account.<br />
If you choose otherwise, the account will be deleted automatically within the next 20 days.
<br /><br />
After clicking the link you should be able to login.
<br /><br />


If you want, you can take the activation key from the email you got and paste it in here:

<?php echo $this->Form->create('User', array('action'=>'registered'));?>
	<fieldset>
 		<legend><?php echo __('Manually activate your account');?></legend>
	<?php
		echo $this->Form->input('akt');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li></li>
	</ul>
</div>




<br /><br />
Note: NO EMAIL is sent! this is a todo!