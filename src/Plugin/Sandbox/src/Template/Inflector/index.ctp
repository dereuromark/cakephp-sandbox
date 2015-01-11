
<h2>Inflector test</h2>
<?php
echo $this->Form->create(false, array('type' => 'get'));
echo $this->Form->input('string', array('label' => false, 'value' => $string));
echo $this->Form->end('Inflect me!');

if (!empty($results)) {
	echo $this->element('Sandbox.inflector/results');
}

?>

<br /><br />
<small>The inflector uses version <?php echo Cake\Core\Configure::version()?> of CakePHP.</small>