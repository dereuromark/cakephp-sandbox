<div class="source-link" style="float: right;">
<?php //echo $this->SourceCode->link(null, array('class' => 'btn btn-info')); ?>
</div>

<h2>Query strings and type safety</h2>
<p>
Query strings are usually strings, but - as some might not be aware of - can also be quite easily an array.
So not checking on the type and blindly using it in stringish operations can currently cause undesired results.
</p>

<?php
$data = <<<'TEXT'
$result = 'string' . $this->request->query('key'); // Dangerous without checking if set and a string
TEXT;
echo $this->Geshi->highlightText($data, 'php');
?>

So with the current implementation of how query strings (and named params) work, one should always assert the correct type first:
<?php
$data = <<<'TEXT'
$key = $this->request->query('key');
if (is_array($key)) { // Or: if (!is_scalar($key))
	throw new NotFoundException('Invalid query string'); // Simple 404
}
$result = 'string' . $this->request->query('key'); // Dangerous without checking if a stringish (=scalar) value
TEXT;
echo $this->Geshi->highlightText($data, 'php');
?>
Annoying - I know. That's why I opened a <a href="">ticket regarding this issue</a>.

<h3>Demo/Example</h3>
<?php
	if (!empty($this->request->query)) {
		echo '<b>Result:</b>';
		echo pre(h($this->request->query));
	}
?>

<b>Let's test:</b>
<p>
<?php echo $this->Html->link('A simple string', array('action' => 'query_strings', '?' => array('key' => 'value'))); ?>

<?php echo $this->Html->link('A simple array', array('action' => 'query_strings', '?' => array('key' => array('v1', 'v2')))); ?>
</p>
