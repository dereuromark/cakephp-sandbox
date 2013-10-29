<?php
//$this->Jquery->plugins(array('form','growfield'));

?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>

$(document).ready(function() {

	$("#dropdown-subject").change(function () {
		var selvalue = $(this).val();
		if (selvalue > 0) {
			$("#selfdefined-subject").hide();
			//$("#own-subject").val(selvalue);
		} else {
			$("#selfdefined-subject").show();
			//$("#own-subject").val('');
		}
	});



});
/*
$(function() {

	$('textareas.contact').growfield( {
		min: 100,
		max: 600,
		animate: false,
		speed: 1,
		restore: false
		}
	);

});
*/


<?php $this->Html->scriptEnd(); ?>

<div>

<h1><?php echo __('contactHeader');?></h1>
Email: <?php echo $this->Format->encodeEmailUrl(Configure::read('Config.admin_email')); ?><br /><br />

<?php echo $this->Form->create('ContactForm');?>
	<fieldset>
 		<legend><?php echo __('contactLegend');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('email');
		echo $this->Form->input('dropdowns', array(
			'label'=>__('Subject'),
			'empty'=>' -[ '.__('contactChoseSubject').' ]- ',
			'id'=>'dropdown-subject'
		));
		echo '<div id="selfdefined-subject" '.((!empty($this->Form->data['Contact']['dropdowns']) && $this->Form->data['Contact']['dropdowns']>0) ? 'style="display:none"' : '').'>';
		echo $this->Form->input('subject', array(
			'label'=>__('contactOwnSubject'),
			'id'=>'own-subject'
		));
		echo '</div><br/>';
		echo $this->Form->input('message', array('type'=>'textarea', 'class'=>'contact', 'label'=>__('contactMessage')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>


</div>