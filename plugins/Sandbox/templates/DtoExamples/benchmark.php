<?php
/**
 * @var \App\View\AppView $this
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
</p>

<div class="alert alert-primary">
	<h4>Run the Benchmark</h4>
	<p>Click the button below to run a live benchmark comparing Entity vs DTO performance.</p>
	<p class="mb-0">
		<?php echo $this->Html->link(
			'Run Benchmark (100 iterations)',
			['action' => 'benchmarkRun'],
			['class' => 'btn btn-primary'],
		); ?>
	</p>
	<small class="text-muted">Note: This may take a few seconds to complete.</small>
</div>

<h2>Key Findings</h2>

<div class="alert alert-success">
	<h4>DTOs are Performance-Competitive</h4>
	<ul class="mb-0">
		<li><strong>Overhead is minimal:</strong> DTO projection adds no relevant overhead, with optimizations even gains some ms.</li>
		<li><strong>Database dominates:</strong> ~95% of query time is database I/O, not hydration.</li>
		<li><strong>Immutability is free:</strong> DTOs provide immutability with negligible cost.</li>
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

<h2>Benchmark Methodology</h2>

<p>The benchmark performs the following tests:</p>
<ul>
	<li><strong>Warm-up:</strong> Initial query to ensure database/cache is ready</li>
	<li><strong>Entity Test:</strong> 100 iterations of <code>find()->contain(['Roles'])->toArray()</code></li>
	<li><strong>DTO Test:</strong> 100 iterations of <code>find()->contain(['Roles'])->projectAs(Dto::class)->toArray()</code></li>
	<li><strong>Single Query:</strong> One iteration of each for detailed breakdown</li>
</ul>

<p>Metrics measured:</p>
<ul>
	<li>Total execution time (ms)</li>
	<li>Average time per query (ms)</li>
	<li>Memory delta (KB)</li>
</ul>

</div></div>
