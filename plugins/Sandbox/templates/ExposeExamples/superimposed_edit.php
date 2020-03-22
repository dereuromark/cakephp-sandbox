<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\ExposedUser $exposedUser
 */
?>
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
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Users')), ['action' => 'superimposedIndex']);?></li>
	</ul>
</div>
