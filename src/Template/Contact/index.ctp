
<h2><?php echo __('Contact Form');?></h2>
<p>
My email address: <?php echo $this->Obfuscate->encodeEmailUrl(Cake\Core\Configure::read('Config.adminEmail')); ?></p>

<?php echo $this->Form->create($contact);?>
	<fieldset>
		<legend><?php echo __('The quickest way to write me an email');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('email');
		echo $this->Form->input('subject');
		echo $this->Form->input('message', ['type' => 'textarea', 'class'=>'contact', 'rows'=>10, 'label'=>__('Your Message')]);

		if (!$this->AuthUser->id()) {
			//echo $this->Captcha->input('Contact');
		}

	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), ['class' => 'submit']);?>
<?php echo $this->Form->end();?>

