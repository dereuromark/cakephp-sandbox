<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Sandbox\Model\Entity\Product> $products
 * @var string $orderClause
 */

$this->Paginator->setConfig('options.sortFormat', 'combined');
?>

<div class="page index">
	<h2>Combined Sort Pagination</h2>

	<p>Including "SortableFieldsBuilder" functionality and Paginator defaulting.</p>

	<div class="alert alert-info">
		<h4>CakePHP 5.3 Feature</h4>
		<p>
			<strong>Combined Sort</strong> allows you to include the sort direction (ASC/DESC) directly in the sort parameter key.
			Instead of separate <code>sort</code> and <code>direction</code> parameters, you can use <code>sort=column-asc</code> or <code>sort=column-desc</code>.
		</p>
		<p>
			<strong>Example URLs:</strong>
		</p>
		<ul>
			<li><code><?= $this->Url->build(['?' => ['sort' => 'title-asc']]) ?></code> - Sort by title ascending</li>
			<li><code><?= $this->Url->build(['?' => ['sort' => 'price-desc']]) ?></code> - Sort by price descending</li>
			<li><code><?= $this->Url->build(['?' => ['sort' => 'expensive-desc']]) ?></code> - Custom multi-column sort, locked (price DESC, then created DESC)</li>
			<li><code><?= $this->Url->build(['?' => ['sort' => 'availability-asc']]) ?></code> - Custom multi-column sort, unlocked (price ASC, then stock ASC)</li>
		</ul>
	</div>

	<table class="table table-striped">
		<thead>
			<tr>
				<th><?= $this->Paginator->sort('title', 'Title') ?></th>
				<th><?= $this->Paginator->sort('price', 'Price') ?> / <?= $this->Paginator->sort('expensive', 'Expensive') ?></th>
				<th><?= $this->Paginator->sort('stock', 'Stock') ?> / <?= $this->Paginator->sort('availability', 'Availability') ?></th>
				<th><?= $this->Paginator->sort('created', 'Created') ?></th>
				<th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products as $product) { ?>
				<tr>
					<td><?= h($product->title) ?></td>
					<td><span class="badge bg-success">$<?= number_format($product->price, 2) ?></span></td>
					<td><span class="badge bg-info"><?= $product->stock ?></span></td>
					<td><?= $this->Time->nice($product->created) ?></td>
					<td><?= $this->Time->nice($product->modified) ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="paginator">
		<div class="float-end mb-2">
			<?php
			$currentLimit = $this->Paginator->param('perPage');
			$maxLimit = $this->Paginator->param('maxLimit') ?: 10;
			$limits = [2, 4, 6, 8, 10];
			$limits = array_filter($limits, fn($limit) => $limit <= $maxLimit);
			?>
			<?php if (count($limits) > 1) { ?>
			<label class="me-2">Show:</label>
			<select class="form-select form-select-sm d-inline-block w-auto" onchange="window.location.href=this.value">
				<?php foreach ($limits as $limitOption) { ?>
					<option value="<?= $this->Url->build(['?' => ['limit' => $limitOption] + $this->request->getQuery()]) ?>" <?= $currentLimit == $limitOption ? 'selected' : '' ?>>
						<?= $limitOption ?>
					</option>
				<?php } ?>
			</select>
			<?php } ?>
		</div>
		<?= $this->element('Tools.pagination') ?>
	</div>

	<h3>Try Combined Sort</h3>
	<div class="mb-3">
		<?php
		$activeSort = $this->request->getQuery('sort');
		$btnClass = function($sortKey) use ($activeSort) {
			return $activeSort === $sortKey ? 'btn btn-sm' : 'btn btn-sm btn-outline';
		};
		?>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'title-asc']]) ?>" class="<?= $activeSort === 'title-asc' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline-primary' ?>">Title ASC</a>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'title-desc']]) ?>" class="<?= $activeSort === 'title-desc' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline-primary' ?>">Title DESC</a>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'price-asc']]) ?>" class="<?= $activeSort === 'price-asc' ? 'btn btn-sm btn-success' : 'btn btn-sm btn-outline-success' ?>">Price ASC (Locked)</a>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'price-desc']]) ?>" class="btn btn-sm btn-outline-secondary text-decoration-line-through disabled" aria-disabled="true"><s>Price DESC</s></a>
		<?php if ($activeSort === 'expensive-desc') { ?>
			<span class="btn btn-sm btn-warning">Most Expensive (Custom, Locked)</span>
		<?php } else { ?>
			<a href="<?= $this->Url->build(['?' => ['sort' => 'expensive-desc']]) ?>" class="btn btn-sm btn-outline-warning">Most Expensive (Custom, Locked)</a>
		<?php } ?>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'expensive-asc']]) ?>" class="btn btn-sm btn-outline-secondary text-decoration-line-through disabled" aria-disabled="true"><s>Expensive ASC</s></a>
	</div>

	<div class="row">
		<div class="col-md-6">
			<h3>Current Query Parameters</h3>
			<pre><?= h(print_r($this->request->getQuery(), true)) ?></pre>
		</div>
		<div class="col-md-6">
			<h3>SQL ORDER BY</h3>
			<pre><?= $orderClause ?: 'No sorting applied' ?></pre>
		</div>
	</div>

	<h3>Implementation</h3>
	<pre><code class="language-php">// Controller - Using SortableFieldsBuilder (CakePHP 5.3)
$this->paginate = [
    'sortableFields' => function ($builder) {
        return $builder
            ->add('title')          // Allows: title-asc, title-desc
            // Lock price to ascending only (for demo purposes)
            ->add('price', SortField::asc('price', locked: true))
            ->add('stock')          // Allows: stock-asc, stock-desc
            ->add('created')        // Allows: created-asc, created-desc
            ->add('modified', SortField::desc('modified'))  // Defaults to DESC
            // Custom multi-column sort: expensive items first (DESC only, locked)
            ->add('expensive', SortField::desc('price', locked: true), SortField::desc('created', locked: true))
            // Custom multi-column sort: availability (price + stock, not locked, can toggle)
            ->add('availability', 'price', 'stock');
    },
    'limit' => 10,
    'maxLimit' => 10,       // Enforce maximum limit
];

// Key Features Demonstrated:
// - Combined sort format: field-direction (e.g., title-asc)
// - Locked direction: price always sorts ASC, expensive always sorts DESC
// - Default direction: modified defaults to DESC (most recent first)
// - Multi-column custom sort (locked): 'expensive' sorts by price DESC, then created DESC
// - Multi-column custom sort (unlocked): 'availability' sorts by price, then stock (toggleable)
// - Pagination limit enforcement via maxLimit</code></pre>
</div>
