<?php
$this->Activecalendar->includeFiles('ceramique');

?>

<div class="examples form">
<?php echo $this->Form->create('Example');?>
	<fieldset>
 		<legend><?php echo __('Edit {0}', __('Example'));?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('link');
		echo $this->Form->input('title');
		echo $this->Form->input('codesnippet_id', ['empty' => ['0' => '- - -']]);

		echo $this->Form->input('published', ['type' => 'text', 'class' => 'datepicker', 'id' => $this->Activecalendar->setId()]);
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $this->Form->value('Example.id')], null, __('Are you sure you want to delete # {0}?', $this->Form->value('Example.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Examples')), ['action' => 'index']);?></li>
		<li><?php echo $this->Html->link(__('List {0}', __('Codesnippets')), ['controller' => 'codesnippets', 'action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('New Codesnippet'), ['controller' => 'codesnippets', 'action' => 'add']); ?> </li>
	</ul>
</div>