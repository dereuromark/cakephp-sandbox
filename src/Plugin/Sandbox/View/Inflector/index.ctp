
<h2>Inflector test</h2>
<?php
echo $this->Form->create(null, array('type' => 'get'));
echo $this->Form->input('string', array('label' => false, 'value' => $string));
echo $this->Form->end('Inflect me!');

if (isset($results) && $results) {
	echo $this->element('Sandbox.inflector/results');
}

?>

<br /><br />
<small>The inflector uses version <?php echo Configure::version()?> of CakePHP.</small>