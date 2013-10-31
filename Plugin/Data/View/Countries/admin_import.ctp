<div class="page form">
<h2>Schnell-Import von Ländern</h2>

<?php
	if (!empty($this->request->data['Form'])) { ?>
	<h3>Speichern</h3>
	<?php echo $this->Form->create('Country');?>
	<fieldset>
		<legend><?php echo __('Import Countries');?></legend>

		<?php if (!empty($countries)) { ?>
		<div class="">
		<?php echo pre(h($countries)); ?>
		</div>
		<?php } ?>

	<?php

		foreach ($this->request->data['Form'] as $key => $val) {
			echo $this->Form->input('Form.' . $key . '.name', array('value' => $val['name']));
			echo $this->Form->input('Form.' . $key . '.iso2', array('value' => $val['iso2']));
			echo $this->Form->input('Form.' . $key . '.iso3', array('value' => $val['iso3']));
			echo $this->Form->input('Form.' . $key . '.confirm', array('checked' => $val['confirm'], 'type' => 'checkbox', 'label' => 'Einfügen'));

			//echo $this->Form->error('Error.'.$key.'name', 'First Name Required');
			if (!empty($this->request->data['Error'][$key]['name'])) {
				echo h($this->request->data['Error'][$key]['name']) . BR;

			}
			echo BR;
		}
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit'));?>
<?php } ?>


<h3>Import</h3>


<?php if (true) { ?>

<?php echo $this->Form->create('Country');?>
	<fieldset>
		<legend><?php echo __('Import Countries');?></legend>
	<?php
		echo $this->Form->input('import_separator', array('options' => Country::separators(), 'empty' => array(0 => 'Eigenen Separator verwenden')));
		echo $this->Form->input('import_separator_custom', array('label' => 'Eigener Separator'));

		echo $this->Form->input('import_pattern', array());
		echo $this->Form->input('import_record_separator', array('options' => Country::separators(), 'empty' => array(0 => 'Eigenen Separator verwenden')));
		echo $this->Form->input('import_record_separator_custom', array('label' => 'Eigener Separator'));

		echo 'Für Pattern verwendbar: &nbsp;&nbsp; <b>{TAB}</b>, <b>{SPACE}</b>, <b>benutzerdefinierte Trennzeichen</b>, <b>%*s</b> (Überspringen), <b>%s</b> (ohne Leerzeichen), <b>%[^.]s</b> (mit Leerzeichen)<br>
		Alles, wofür %name zutrifft, verwendet wird, der Rest geht verloren. Was als Separator ausgewählt wurde (zum Trennen der einzelnen Datensätze), kann logischerweise nicht mehr im Pattern verwendet werden (zum Herausfiltern des Namens)!';
		echo BR;
		echo BR;
		echo $this->Form->input('import_content', array('type' => 'textarea', 'rows' => 30));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>

<?php } else { ?>

<?php echo $this->Html->link('Neuer Import', array('action' => 'import')); ?>

<?php } ?>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List %s', __('Dances')), array('action' => 'index'));?></li>
	</ul>
</div>