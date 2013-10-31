
<div class="page form">
<?php echo $this->Form->create('Currency');?>
	<fieldset>
		<legend><?php echo __('Add %s', __('Currency'));?></legend>

	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('code', array('datalist' => $currencies));
		echo $this->Form->input('symbol_left');
		echo $this->Form->input('symbol_right');
		echo $this->Form->input('decimal_places');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<br />

Wird nur der Code angegeben, wird versucht, den Name automatisch dazu zu finden.
Das selbe gilt für den aktuellen Wechselkurs.

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List %s', __('Currencies')), array('action' => 'index'));?></li>
	</ul>
</div>