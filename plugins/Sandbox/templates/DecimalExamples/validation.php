<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $record
 * @var \PhpCollective\DecimalObject\Decimal|null $result
 */

?>
<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/decimal'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Validation Demo</h3>

	<p>By default, it uses system locale (en), you can also switch to any other one:</p>
	<ul>
		<li><?php echo $this->Html->link('de_DE', ['action' => 'validation', 'de_DE', '?' => ['value' => $this->request->getQuery('value')]]); ?></li>
		<li><?php echo $this->Html->link('en', ['action' => 'validation', 'en', '?' => ['value' => $this->request->getQuery('value')]]); ?></li>
		<li><?php echo $this->Html->link('es', ['action' => 'validation', 'es', '?' => ['value' => $this->request->getQuery('value')]]); ?></li>
	</ul>

	<p>We use the following validation rule to assert 2 decimal digits:</p>
	<?php
	$code = '->decimal(\'balance\', 2);';
	echo $this->Highlighter->highlight($code, ['lang' => 'php']);
	?>

	And we do need to activate locale parsing on the decimal type:
	<?php
	$code = 'TypeFactory::build(\'decimal\')->useLocaleParser();';
	echo $this->Highlighter->highlight($code, ['lang' => 'php']);
	?>

	<?php echo $this->Form->create($record, ['novalidate' => true]);?>
	<fieldset>
		<legend><?php echo __('Enter a valid value');?></legend>
		<?php
		echo $this->Form->control('balance', ['type' => 'text', 'placeholder' => '0.00', 'default' => $this->request->getQuery('value')]);
		?>
	</fieldset>


	<h4>Resulting value (object)</h4>
	<pre><?php echo print_r($result, true) ?></pre>

	<?php
	echo $this->Form->submit(__('Submit'));
	echo $this->Form->end();
	?>


	<p>Note:</p>
	<ul>
		<li>The input on purpose has been made text input instead of number input to showcase validation better (also non numeric characters possible).</li>
		<li>The form has novalidate true set to make sure it can always be posted, even if not yet valid.</li>
	</ul>

</div></div>
