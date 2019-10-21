<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php echo $this->Html->script('/sandbox/jquery.maxlength/jquery.maxlength', ['block' => true]) ?>
<?php echo $this->Html->css('/sandbox/jquery.maxlength/style', ['block' => true]) ?>

<?php $this->append('script'); ?>
<script type="text/javascript">

// wait for the DOM to be loaded
$(document).ready(function() {
	$('#jquery-example-comment').maxlength();
	$('#jquery-example-text').maxlength();
});

</script>
<?php $this->end(); ?>

<h1><?php echo __('Max length');?></h1>

<?php
echo $this->Form->create(null, ['id' => 'jquery-example-form']);
echo $this->Form->control('comment', ['type' => 'textarea', 'maxlength' => '20', 'id' => 'jquery-example-comment']);
echo $this->Form->control('text', ['maxlength' => '20', 'id' => 'jquery-example-text']);
echo $this->Form->submit('Submit Test');
echo $this->Form->end();
