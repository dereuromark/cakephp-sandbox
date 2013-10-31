<h2><?php echo __('Edit %s', __('Language')); ?></h2>

<div class="page form">
<?php echo $this->Form->create('Language');?>
	<fieldset>
		<legend><?php echo __('Edit %s', __('Language')); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('ori_name');
		echo $this->Form->input('code');
		echo $this->Form->input('locale');
		echo $this->Form->input('locale_fallback');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Language.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Language.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Languages')), array('action' => 'index'));?></li>
	</ul>
</div>