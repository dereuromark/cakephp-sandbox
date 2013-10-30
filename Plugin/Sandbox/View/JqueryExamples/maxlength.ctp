<?php echo $this->Html->script('/sandbox/jquery.maxlength/jquery.maxlength')?>
<?php echo $this->Html->css('/sandbox/jquery.maxlength/style')?>

<script type="text/javascript">

// wait for the DOM to be loaded
$(document).ready(function() {
	$('#JqueryExampleComment').maxlength();
	$('#JqueryExampleText').maxlength();
});

</script>

<h1><?php echo __('Max length');?></h1>

<?php
echo $this->Form->create('JqueryExample');
echo $this->Form->input('comment', array('type'=>'textarea', 'maxlength' => '20'));
echo $this->Form->input('text', array('maxlength' => '20'));

echo $this->Form->end('Submit Test');
?>

