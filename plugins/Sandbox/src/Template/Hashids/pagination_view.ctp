<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page index">


<h2><?php echo h($country['name']);?></h2>

	<table class="table list" width="100%">
			<tr>
				<td>
					<?php echo h($country['id']); ?>
				</td>
				<td>
					<?php echo $this->Html->link($country['name'], ['action' => 'paginationView', $country->id]); ?>
				</td>
				<td>
					<?php echo h($country['iso2']); ?>
				</td>
				<td>
					<?php echo h($country['iso3']); ?>
				</td>
				<td>
					<?php echo $this->Time->nice($country['modified']); ?>
				</td>
			</tr>
	</table>

</div>


<ul>
	<li><?php echo $this->Html->link('Back', ['action' => 'pagination', '?' => $this->request->getQuery()]); ?></li>
</ul>
