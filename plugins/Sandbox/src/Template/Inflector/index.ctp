<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h2>Inflector test</h2>

<p>Test the CakePHP internal "inflecting" functionality.</p>

<?php
echo $this->Form->create(false, ['type' => 'get']);
echo $this->Form->control('string', ['label' => 'Word', 'value' => $string]);
echo $this->Form->submit('Inflect me!');
echo $this->Form->end();

if (!empty($results)) {
	echo $this->element('Sandbox.inflector/results');
}

?>

<p>Note: Do not try to inflect twice (plural to plural, or singular to singular) as this is not supposed to work.</p>


<br /><br />
<small>The inflector uses version <?php echo $this->Configure->version()?> of CakePHP.</small>
