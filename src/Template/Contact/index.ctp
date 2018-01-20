<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2><?php echo __('Contact Form');?></h2>
<p>
My email address: <?php echo $this->Obfuscate->encodeEmailUrl(Cake\Core\Configure::read('Config.adminEmail')); ?></p>

<?php echo $this->Form->create($contact);?>
	<fieldset>
		<legend><?php echo __('The quickest way to write me an email');?></legend>
	<?php
		echo $this->Form->control('name');
		echo $this->Form->control('email');
		echo $this->Form->control('subject');
		echo $this->Form->control('body', ['type' => 'textarea', 'class'=>'contact', 'rows'=>10, 'label'=>__('Your Message')]);

		echo $this->Captcha->render(['placeholder' => __('Please solve the riddle')]);

	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), ['class' => 'submit']);?>
<?php echo $this->Form->end();?>

