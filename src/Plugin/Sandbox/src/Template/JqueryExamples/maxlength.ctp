<?php echo $this->Html->script('/sandbox/jquery.maxlength/jquery.maxlength')?>
<?php echo $this->Html->css('/sandbox/jquery.maxlength/style')?>

<script type="text/javascript">

// wait for the DOM to be loaded
$(document).ready(function() {
	$('#jquery-example-comment').maxlength();
	$('#jquery-example-text').maxlength();
});

</script>

<h1><?php echo __('Max length');?></h1>

<?php
echo $this->Form->create('JqueryExample', ['id' => 'jquery-example-form']);
echo $this->Form->input('comment', array('type' => 'textarea', 'maxlength' => '20', 'id' => 'jquery-example-comment'));
echo $this->Form->input('text', array('maxlength' => '20', 'id' => 'jquery-example-text'));
echo $this->Form->submit('Submit Test');
echo $this->Form->end();
