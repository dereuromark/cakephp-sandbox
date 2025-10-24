<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $record
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

	<h3>Form Demo</h3>

	<p>When working with decimals coming from DB and displaying it both in views and forms, we want to check how nice the value objects work here for us.</p>

	<p>For this to work directly with the object for all our decimal columns we mapped them to the Type class:</p>
<?php
$code = <<<TXT
\Cake\Database\TypeFactory::map(
    'decimal',
    'CakeDecimal\Database\Type\DecimalObjectType',
);
TXT;
echo $this->Highlighter->highlight($code, ['lang' => 'php']);

?>

	<p>We then pull a record from DB. If we echo the `balance` field:</p>

	<?php
	$code = print_r($record->balance, true);
	echo $this->Highlighter->highlight($code, ['lang' => 'php']);
	?>

	<p>The `extra` field is first empty (null):</p>
	<?php
	$code = print_r($record->extra, true);
	echo $this->Highlighter->highlight($code, ['lang' => 'php']);
	?>

	<p>Now, lets add something to it via edit form</p>


	<?php echo $this->Form->create($record);?>
	<fieldset>
		<legend><?php echo __('Set balance and extra amount');?></legend>
		<?php
		echo $this->Form->control('balance', ['placeholder' => '0.00']);
		echo $this->Form->control('extra', ['placeholder' => '0.00']);
		?>
	</fieldset>

	<p>`balance` is a required not null field, `extra` is nullable.</p>

	<?php
	echo $this->Form->submit(__('Submit'));
	echo $this->Form->end();
	?>

</div></div>
