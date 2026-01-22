<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, mixed> $results
 * @var array<\App\Model\Entity\User> $entities
 * @var array<\App\Dto\UserProjectionDto> $dtos
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h1>Benchmark Results</h1>

<p>
	<?php echo $this->Html->link('Back to Benchmark Info', ['action' => 'benchmark'], ['class' => 'btn btn-secondary btn-sm']); ?>
</p>

<div class="alert alert-info">
	<strong>Test Configuration:</strong>
	<?php echo $results['iterations']; ?> iterations,
	<?php echo $results['recordCount']; ?> records per query (Users with BelongsTo Role)
</div>

<h2>Results</h2>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Metric</th>
			<th>Entity</th>
			<th>DTO</th>
			<th>Difference</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>Total Time (<?php echo $results['iterations']; ?> iterations)</strong></td>
			<td><?php echo $results['entity']['totalMs']; ?> ms</td>
			<td><?php echo $results['dto']['totalMs']; ?> ms</td>
			<td>
				<?php
				$diff = $results['dto']['totalMs'] - $results['entity']['totalMs'];
				$class = $diff > 0 ? 'text-warning' : 'text-success';
				echo "<span class=\"{$class}\">" . ($diff > 0 ? '+' : '') . round($diff, 2) . ' ms</span>';
				?>
			</td>
		</tr>
		<tr>
			<td><strong>Average per Query</strong></td>
			<td><?php echo $results['entity']['avgMs']; ?> ms</td>
			<td><?php echo $results['dto']['avgMs']; ?> ms</td>
			<td>
				<?php
				$overhead = $results['comparison']['overheadMs'];
				$class = $overhead > 0.1 ? 'text-warning' : 'text-success';
				echo "<span class=\"{$class}\">" . ($overhead > 0 ? '+' : '') . $overhead . ' ms</span>';
				?>
			</td>
		</tr>
		<tr>
			<td><strong>Memory Delta</strong></td>
			<td><?php echo $results['entity']['memoryKb']; ?> KB</td>
			<td><?php echo $results['dto']['memoryKb']; ?> KB</td>
			<td><?php echo round($results['dto']['memoryKb'] - $results['entity']['memoryKb'], 2); ?> KB</td>
		</tr>
	</tbody>
</table>

<h2>Single Iteration Breakdown</h2>
<p>Detailed timing for a single query (includes database + hydration):</p>
<table class="table table-bordered">
	<tr>
		<td>Entity Query + Hydration</td>
		<td><?php echo $results['single']['entityMs']; ?> ms</td>
	</tr>
	<tr>
		<td>DTO Query + Projection</td>
		<td><?php echo $results['single']['dtoMs']; ?> ms</td>
	</tr>
	<tr>
		<td><strong>DTO Overhead</strong></td>
		<td>
			<?php
			$singleDiff = $results['single']['diffMs'];
			$class = $singleDiff > 0.5 ? 'text-warning' : 'text-success';
			echo "<span class=\"{$class}\">" . ($singleDiff > 0 ? '+' : '') . $singleDiff . ' ms</span>';
			?>
		</td>
	</tr>
</table>

<div class="alert alert-success">
	<h4>Conclusion</h4>
	<p class="mb-0">
		DTO projection runs at <strong><?php echo $results['comparison']['dtoPct']; ?>%</strong> of Entity time.
		<?php if ($results['comparison']['dtoPct'] <= 105): ?>
		DTOs are performance-competitive with Entities!
		<?php endif; ?>
	</p>
</div>

</div></div>
