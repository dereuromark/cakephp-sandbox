<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\ExposedUser $exposedUser
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/expose'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<div class="users form">
	<h3><?= __('Exposed Users through superimposition') ?></h3>

<?php echo $this->Form->create($exposedUser);?>
	<fieldset>
 		<legend><?php echo __('Edit {0}', __('User'));?></legend>
	<?php
		echo $this->Form->control('some_field', ['placeholder' => 'Only alphanumeric chars']);
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>

</div></div>
