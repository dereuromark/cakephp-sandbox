<div class="page form">
<?php echo $this->Form->create('CountryProvince');?>
	<fieldset>
		<legend><?php echo __('Edit %s', __('CountryProvince'));?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('country_id', array('empty'=>' - [ '.__('pleaseSelect').' ]- ','required'=>1));
		echo $this->Form->input('name', array('required'=>1));
		echo $this->Form->input('abbr');

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action'=>'delete', $this->Form->value('CountryProvince.id')), array('escape'=>false), __('Are you sure you want to delete # %s?', $this->Form->value('CountryProvince.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('CountryProvinces')), array('action'=>'index'));?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('controller'=> 'countries', 'action'=>'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Add %s', __('Country')), array('controller'=> 'countries', 'action'=>'add')); ?> </li>
	</ul>
</div>