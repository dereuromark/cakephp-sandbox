<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Dto Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-dto" target="_blank">[CakeDto Plugin]</a>
</p>

<h3>DTOs</h3>
<p>Using Data Transfer Objects you can more easily work with all kind of array like data.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('') ?></li>
	<li><?php echo $this->Navigation->link('Basic Usage', ['action' => 'index'])?></li>
	<li><?php echo $this->Navigation->link('Github API demo', ['action' => 'github'])?></li>
	<li><?php echo $this->Navigation->link('DTO schema generator', ['action' => 'generator'])?></li>
</ul>

<h3>ORM Projection</h3>
<p>Project ORM query results directly into DTOs using <code>projectAs()</code>.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li><?php echo $this->Navigation->link('BelongsTo', ['action' => 'projection'])?></li>
	<li><?php echo $this->Navigation->link('HasMany', ['action' => 'projectionHasMany'])?></li>
	<li><?php echo $this->Navigation->link('BelongsToMany', ['action' => 'projectionBelongsToMany'])?></li>
	<li><?php echo $this->Navigation->link('Matching', ['action' => 'projectionMatching'])?></li>
</ul>

<h3>Performance</h3>
<p>Entity vs DTO performance comparison.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li><?php echo $this->Navigation->link('Benchmark Info', ['action' => 'benchmark'])?></li>
	<li><?php echo $this->Navigation->link('Run Benchmark', ['action' => 'benchmarkRun'])?></li>
</ul>
