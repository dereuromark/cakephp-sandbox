<?php
//$this->Jquery->plugins(array('form','growfield'));
?>
<div>

<h2><?php echo __('contactHeader');?></h2>
Email: <?php echo $this->Format->encodeEmailUrl(Configure::read('Config.admin_email')); ?><br /><br />

<?php echo $this->Form->create('ContactForm');?>
	<fieldset>
 		<legend><?php echo __('contactLegend');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('email');
		echo $this->Form->input('subject', array(
			'label' => __('contactSubject'),
		));
		echo $this->Form->input('message', array('type' => 'textarea', 'label' => __('contactMessage')));

		echo $this->Captcha->passive();
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>


</div>