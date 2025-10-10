<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\BitmaskedRecord[] $records
 * @var \Sandbox\Model\Entity\BitmaskedRecord $bitmaskedRecord
 * @var bool $required
 * @var string $field
 */
?>
<h2>Bitmasks via enums</h2>
	<p>Using the BitmaskedBehavior of Tools plugin.</p>

<p><?php echo $this->Html->link('Optional (nullable) field', ['?' => ['required' => false]]); ?> | <?php echo $this->Html->link('Required (not nullable) field', ['?' => ['required' => true]]); ?></p>

<h3>Table</h3>
<p>Some example records stored in DB</p>

<table class="table list">
<tr>
	<th>Id</th>
	<th>Name</th>
	<th>Flags raw (bitmasked)</th>
	<th>Flags (array)</th>
</tr>
<?php foreach ($records as $record) { ?>
<tr>
	<td><?php echo h($record->id); ?></td>
	<td><?php echo h($record->name); ?></td>
	<td><?php echo h($record->$field); ?></td>
	<td><ul><?php
		/** @var \BackedEnum&\Cake\Database\Type\EnumLabelInterface $flag */
		foreach ($record->flags as $flag) {
			echo '<li>' . $flag->value . ' (' . $flag->label() . ')<br><code>' . print_r($flag, true) . '</code></br></li>';
		} ?></ul>
	</td>
</tr>
<?php } ?>
</table>

<h3>Demo for <?php echo $required ? 'not nullable' : 'nullable'; ?> bitmask field `<?php echo h($field) ;?>`</h3>

<div class="page form">
<?php echo $this->Form->create($bitmaskedRecord);?>
	<fieldset>
 		<legend><?php echo __('Add {0}', __('Entry')); ?></legend>
	<?php
		echo $this->Form->control('name');
		echo $this->Form->control('flags', ['type' => 'select', 'multiple' => 'checkbox']);

		// When using mappedField, one needs to manually include error handling or use
	    // $bitmaskedRecord->setError('flags', $bitmaskedRecord->getError($field)); error mapping in the controller
		//echo $this->Form->error($field);
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'));
echo $this->Form->end();?>
</div>
