<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface<array<string, mixed>> $results
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<div class="form">
<h2>Custom Pagination</h2>
	<p>Show custom pagination of any collection (e.g. array from XML).</p>
	<p>
		Tip: Use e.g. a <?php echo $this->Html->link('limit of 1', ['?' => ['limit' => 1]]); ?>.
	</p>

	<?php
	$code = <<<'TXT'
$collection = new \Cake\Collection\Collection($items);

$paginator = new \Sandbox\Controller\Paginator\CollectionPaginator($this->request->getQuery());
$results = $paginator->paginate($collection);
TXT;
	echo $this->Highlighter->highlight(print_r($code, true), ['lang' => 'php']);
	?>

	<table class="table">
		<tr>
			<th>Title</th>
		</tr>
		<?php foreach ($results as $result) { ?>
		<tr><td><?php echo h($result['title']);?></td></tr>
		<?php } ?>
	</table>
<?php

echo $this->element('Tools.pagination');
?>

</div></div>
