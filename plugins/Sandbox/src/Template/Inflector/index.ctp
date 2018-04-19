<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h2>Inflector test</h2>
<?php
echo $this->Form->create(false, ['type' => 'get']);
echo $this->Form->control('string', ['label' => false, 'value' => $string]);
echo $this->Form->submit('Inflect me!');
echo $this->Form->end();

if (!empty($results)) {
	echo $this->element('Sandbox.inflector/results');
}

?>

<br /><br />
<small>The inflector uses version <?php echo $this->Configure->version()?> of CakePHP.</small>
