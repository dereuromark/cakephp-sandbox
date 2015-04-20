
<h2>Inflector test</h2>
<?php
echo $this->Form->create(false, ['type' => 'get']);
echo $this->Form->input('string', ['label' => false, 'value' => $string]);
echo $this->Form->submit('Inflect me!');
echo $this->Form->end();

if (!empty($results)) {
	echo $this->element('Sandbox.inflector/results');
}

?>

<br /><br />
<small>The inflector uses version <?php echo Cake\Core\Configure::version()?> of CakePHP.</small>