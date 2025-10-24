<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Sandbox\Model\Entity\SandboxPost> $posts
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/bootstrap'); ?>
</nav>
<div class="page paginator col-sm-8 col-12">

<h3>PaginatorHelper</h3>
<p>Bootstrap-styled pagination components for navigating through paginated data.</p>

<h4>Sample Data Table</h4>
<p class="text-muted">Showing 5 items per page</p>
<div class="table-responsive mb-4">
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?= $this->Paginator->sort('id') ?></th>
				<th><?= $this->Paginator->sort('title') ?></th>
				<th><?= $this->Paginator->sort('published', 'Status') ?></th>
				<th><?= $this->Paginator->sort('created') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($posts as $post) { ?>
			<tr>
				<td><?= h($post->id) ?></td>
				<td><?= h($post->title) ?></td>
				<td>
					<?php if ($post->published) { ?>
						<span class="badge bg-success">Published</span>
					<?php } else { ?>
						<span class="badge bg-secondary">Draft</span>
					<?php } ?>
				</td>
				<td><?= h($post->created?->format('Y-m-d')) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<h4>Basic Pagination</h4>
<div class="card mb-3">
	<div class="card-body">
		<nav>
			<ul class="pagination">
				<?= $this->Paginator->first('<< First') ?>
				<?= $this->Paginator->prev('< Previous') ?>
				<?= $this->Paginator->numbers() ?>
				<?= $this->Paginator->next('Next >') ?>
				<?= $this->Paginator->last('Last >>') ?>
			</ul>
		</nav>
	</div>
	<div class="card-footer">
		<code>
			&lt;?= $this->Paginator->first('&lt;&lt; First') ?&gt;<br>
			&lt;?= $this->Paginator->prev('&lt; Previous') ?&gt;<br>
			&lt;?= $this->Paginator->numbers() ?&gt;<br>
			&lt;?= $this->Paginator->next('Next &gt;') ?&gt;<br>
			&lt;?= $this->Paginator->last('Last &gt;&gt;') ?&gt;
		</code>
	</div>
</div>

<h4>Using links() Method</h4>
<p>The <code>links()</code> method generates all pagination elements in one call.</p>
<div class="card mb-3">
	<div class="card-body">
		<?= $this->Paginator->links() ?>
	</div>
	<div class="card-footer">
		<code>
			&lt;?= $this->Paginator->links() ?&gt;
		</code>
	</div>
</div>

<h4>Custom Configuration</h4>
<p>Customize which elements are shown and their labels.</p>
<div class="card mb-3">
	<div class="card-body">
		<?= $this->Paginator->links([
			'first' => 'First',
			'last' => 'Last',
			'prev' => '❮',
			'next' => '❯',
		]) ?>
	</div>
	<div class="card-footer">
		<code>
			&lt;?= $this->Paginator->links([<br>
			&nbsp;&nbsp;'first' => 'First',<br>
			&nbsp;&nbsp;'last' => 'Last',<br>
			&nbsp;&nbsp;'prev' => '❮',<br>
			&nbsp;&nbsp;'next' => '❯',<br>
			]) ?&gt;
		</code>
	</div>
</div>

<h4>Large Pagination</h4>
<p>Use the <code>size</code> option for larger pagination controls.</p>
<div class="card mb-3">
	<div class="card-body">
		<?= $this->Paginator->links(['size' => 'lg']) ?>
	</div>
	<div class="card-footer">
		<code>
			&lt;?= $this->Paginator->links(['size' => 'lg']) ?&gt;
		</code>
	</div>
</div>

<h4>Small Pagination</h4>
<p>Use smaller controls for compact layouts.</p>
<div class="card mb-3">
	<div class="card-body">
		<?= $this->Paginator->links(['size' => 'sm']) ?>
	</div>
	<div class="card-footer">
		<code>
			&lt;?= $this->Paginator->links(['size' => 'sm']) ?&gt;
		</code>
	</div>
</div>

<h4>Pagination Information</h4>
<p>Display pagination stats using the counter.</p>
<div class="card mb-3">
	<div class="card-body">
		<p class="text-muted">
			<?= $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total') ?>
		</p>
		<p class="text-muted">
			<?= $this->Paginator->counter('Showing {{start}} to {{end}} of {{count}} entries') ?>
		</p>
		<p class="text-muted">
			<?= $this->Paginator->counter('Range: {{start}} - {{end}}') ?>
		</p>
	</div>
	<div class="card-footer">
		<code>
			&lt;?= $this->Paginator->counter('Page {{page}} of {{pages}}...') ?&gt;
		</code>
	</div>
</div>

<h4>Sortable Columns</h4>
<p>The <code>sort()</code> method creates sortable column headers.</p>
<div class="card mb-3">
	<div class="card-body">
		<table class="table">
			<thead>
				<tr>
					<th><?= $this->Paginator->sort('id', 'ID') ?></th>
					<th><?= $this->Paginator->sort('name', 'Animal Name') ?></th>
					<th><?= $this->Paginator->sort('created', 'Created Date') ?></th>
				</tr>
			</thead>
		</table>
		<p class="text-muted small">Click column headers to sort (requires full page reload)</p>
	</div>
	<div class="card-footer">
		<code>
			&lt;?= $this->Paginator->sort('name', 'Animal Name') ?&gt;
		</code>
	</div>
</div>

<h4>Has Previous/Next Checks</h4>
<p>Check if previous or next pages exist programmatically.</p>
<div class="card mb-3">
	<div class="card-body">
		<p>
			<strong>Has Previous:</strong> <?= $this->Paginator->hasPrev() ? 'Yes' : 'No' ?>
			<br>
			<strong>Has Next:</strong> <?= $this->Paginator->hasNext() ? 'Yes' : 'No' ?>
		</p>
	</div>
	<div class="card-footer">
		<code>
			$this->Paginator->hasPrev()<br>
			$this->Paginator->hasNext()
		</code>
	</div>
</div>

<div class="alert alert-info">
	<strong>Bootstrap Styling:</strong> The BootstrapUI PaginatorHelper automatically applies Bootstrap 5 classes
	(<code>pagination</code>, <code>page-item</code>, <code>page-link</code>) to create properly styled pagination components.
</div>

</div>
</div>
