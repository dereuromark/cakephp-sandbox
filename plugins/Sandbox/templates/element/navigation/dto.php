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
	<li class="nav-item"><?php echo $this->Navigation->link('Basic Usage', ['action' => 'index'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Github API demo', ['action' => 'github'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('DTO schema generator', ['action' => 'generator'], ['class' => 'nav-link'])?></li>
</ul>

<h3>ORM Projection</h3>
<p>Project ORM query results directly into DTOs using <code>projectAs()</code>.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="nav-item"><?php echo $this->Navigation->link('BelongsTo', ['action' => 'projection'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('HasMany', ['action' => 'projectionHasMany'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('BelongsToMany', ['action' => 'projectionBelongsToMany'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Matching', ['action' => 'projectionMatching'], ['class' => 'nav-link'])?></li>
</ul>

<h3>Performance</h3>
<p>Entity vs DTO performance comparison.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="nav-item"><?php echo $this->Navigation->link('Benchmark Info', ['action' => 'benchmark'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Run Benchmark', ['action' => 'benchmarkRun'], ['class' => 'nav-link'])?></li>
</ul>
