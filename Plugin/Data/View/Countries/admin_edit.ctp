<div class="page form">
<?php echo $this->Form->create('Country');?>
	<fieldset>
		<legend><?php echo __('Edit %s', __('Country'));?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('ori_name');
		echo $this->Form->input('iso2');
		echo $this->Form->input('iso3');
		echo $this->Form->input('country_code');
		echo $this->Form->input('special');
		echo $this->Form->input('address_format', array('type' => 'textarea'));
		echo '<div class="input checkbox">Platzhalter sind :name :street_address :postcode :city :country</div>';
		echo BR;

		//echo $this->Form->input('sort');
		echo $this->Form->input('status', array('type' => 'checkbox', 'label' => 'Aktiv'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Country.id')), array('escape' => false), __('Are you sure you want to delete # %s?', $this->Form->value('Country.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Country Provinces'), array('controller' => 'country_provinces', 'action' => 'index')); ?> </li>
	</ul>
</div>