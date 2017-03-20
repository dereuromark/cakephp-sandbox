<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h1>Analyze Text</h1>
Count words, sentences, etc

<h2>Analyzer</h2>

<div class="examples form">
<?php echo $this->Form->create('Tool');?>
	<fieldset>
 		<legend><?php echo __('Enter Text');?></legend>
	<?php
		echo $this->Form->input('Form.text', ['type' => 'textarea', 'class' => 'halfSize', 'rows' => 15]);
		//echo $this->Form->input('Form.type', array('empty'=>array('0'=>'- [auto-detect] -')));
		echo $this->Form->input('Form.min_char', []);
		echo $this->Form->input('Form.max_char', []);
		echo $this->Form->input('Form.sort', ['options' => ['' => '- [none] -', 'asc' => 'ASC', 'desc' => 'DESC']]);
		echo $this->Form->input('Form.limit');

		//echo $this->Form->input('Form.prevent_trim', array('type'=>'hidden', 'value'=>1));
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>

<h2>Result</h2>
<?php
if (!empty($results)) {
	echo $results['sentence_count'] . ' Sätze in ' . $results['paragraph_count'] . ' Absätzen mit einer Gesamtlänge von ' . $results['length'] . ' Buchstaben.';
	echo BR;
	echo 'Es handelt sich um einen ' . ($results['is_ascii'] ? '' : 'Nicht-') . 'ASCII Text.';
	echo BR . BR;

	echo 'Ingesamt ' . $results['word_count'] . ' Wörter, davon sind einmalig: ';

	echo count($results['words']) . ' Wörter';

	foreach ($results['words'] as $result => $occ) {
		echo '<li>';
		echo h($result) . ' (' . $occ . ')';
		echo '</li>';
	}

}
?>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Back'), ['action' => 'index']);?></li>
	</ul>
</div>