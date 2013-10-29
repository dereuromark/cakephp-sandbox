<div class="codesnippetCats index">
<h1><?php echo __('Codebase');?></h1>
This CodeBase consists of 3 different categories:
<ul>
<li>

Tutorials (with source files)

</li><li>

Modules (download, extract, configure and run)

</li><li>

Codesnippets (again grouped by categories and elements)

</li>
</ul>

<br />
Additionally, there will be
<ul>
<li>

Examples (usually they belong to a codesnippet)

</li>

<li>

Idea Pool (with some thoughts on maybe further projects / updates)

</li>

</ul>

<br />
<h2>Recent Changes / Updates</h2>
...



<br /><br />


<table class="list">
<tr>
	<th>Name</th>
	<th class="actions"><?php echo __('Last Updates');?></th>
</tr>
<?php
$i = 0;
foreach ($codesnippetCats as $codesnippetCat):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($codesnippetCat['CodesnippetCat']['name'], array('action'=>'view', $codesnippetCat['CodesnippetCat']['id']), array('title'=>'Show all in this category')); ?>

		</td>
		<td class="updates">
			<?php
			echo '<ul>';
	if (is_array($codesnippetCat['Codesnippet']) && count($codesnippetCat['Codesnippet'])>0) {

		foreach ($codesnippetCat['Codesnippet'] as $snippet) {
			echo '<li>'.$this->Html->link($snippet['title'], array('controller'=>'codesnippets','action'=>'view', $snippet['id']), array('title'=>'View codesnippet')).'</li>';
		}
	} else { echo '<li><i>n/a</i></li>'; }
	echo '</ul>';
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>



<br /><br />


<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Search for a particular Codesnippet'), array('controller'=> 'codesnippets', 'action'=>'index')); ?> </li>
	</ul>
</div>