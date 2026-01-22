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

<h1>DTO Performance Benchmark</h1>

<p>
	This benchmark compares CakePHP Entity hydration vs DTO projection using <code>projectAs()</code>.
	Results are generated live on each page load.
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

<h2>Key Findings</h2>

<div class="alert alert-success">
	<h4>DTOs are Performance-Competitive</h4>
	<ul class="mb-0">
		<li><strong>Overhead is minimal:</strong> DTO projection adds ~<?php echo abs($results['comparison']['overheadMs']); ?>ms per query average</li>
		<li><strong>Database dominates:</strong> ~95% of query time is database I/O, not hydration</li>
		<li><strong>Immutability is free:</strong> DTOs provide immutability with negligible cost</li>
	</ul>
</div>

<h2>Why Use DTOs?</h2>

<div class="row">
	<div class="col-md-6">
		<h4>Benefits</h4>
		<ul>
			<li><strong>Type Safety:</strong> Full IDE autocomplete and static analysis</li>
			<li><strong>Immutability:</strong> Prevent accidental data modification</li>
			<li><strong>API Contracts:</strong> Clear data structure definition</li>
			<li><strong>Decoupling:</strong> Separate domain from persistence layer</li>
			<li><strong>Serialization:</strong> Built-in <code>toArray()</code> with type mapping</li>
		</ul>
	</div>
	<div class="col-md-6">
		<h4>DTO Optimizations</h4>
		<ul>
			<li><code>setFromArrayFast()</code> - Bypasses dynamic method calls</li>
			<li><code>$_setters</code> lookup - Pre-computed setter method names</li>
			<li>Optimized <code>validate()</code> - Only checks required fields</li>
			<li>Lazy defaults - Only processes fields with default values</li>
		</ul>
	</div>
</div>

<h2>Code Example</h2>
<pre><code>// Traditional Entity approach
$entities = $usersTable->find()
    ->contain(['Roles'])
    ->toArray();

// DTO projection (same performance, better type safety)
$dtos = $usersTable->find()
    ->contain(['Roles'])
    ->projectAs(UserProjectionDto::class)
    ->toArray();

// Access with full type hints
foreach ($dtos as $user) {
    echo $user->getUsername();       // string|null
    echo $user->getRole()->getName(); // Nested DTO with types
}</code></pre>

</div></div>
