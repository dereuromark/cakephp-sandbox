<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface<array<string, mixed>> $results
 */
?>
<div class="form">
<h2>Custom Pagination</h2>
	<p>sss</p>


	<table>
		<tr>
			<th>Title</th>
		</tr>
		<?php foreach ($results as $result) { ?>
		<tr><td><?php echo h($result['title']);?></td></tr>
		<?php } ?>
	</table>
<?php
debug($results);


echo $this->element('Tools.pagination');
?>
