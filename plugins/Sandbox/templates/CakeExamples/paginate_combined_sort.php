<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>

<div class="page index">
	<h2>Combined Sort Pagination</h2>

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
			<li><code><?= $this->Url->build(['?' => ['sort' => 'expensive-desc']]) ?></code> - Custom multi-column sort (price DESC, then created DESC)</li>
		</ul>
	</div>

	<?php
	$currentSort = $this->request->getQuery('sort');
	$sortHelper = function ($field, $label = null, $locked = false) use ($currentSort) {
		$label = $label ?: ucfirst($field);
		$isAsc = $currentSort === $field . '-asc';
		$isDesc = $currentSort === $field . '-desc';

		// For locked fields, always use asc
		if ($locked) {
			$nextSort = $field . '-asc';
			$isActive = $isAsc;
		} else {
			$nextSort = $isAsc ? $field . '-desc' : $field . '-asc';
			$isActive = $isAsc || $isDesc;
		}

		$arrow = '';
		if ($isAsc) {
			$arrow = ' ▲';
		} elseif ($isDesc && !$locked) {
			$arrow = ' ▼';
		}

		// If locked and active, don't make it a link
		if ($locked && $isActive) {
			return sprintf(
				'<span>%s%s</span>',
				h($label),
				$arrow
			);
		}

		return sprintf(
			'<a href="%s">%s%s</a>',
			$this->Url->build(['?' => ['sort' => $nextSort]]),
			h($label),
			$arrow
		);
	};
	?>

	<table class="table table-striped">
		<thead>
			<tr>
				<th><?= $sortHelper('title', 'Title') ?></th>
				<th><?= $sortHelper('price', 'Price', true) ?></th>
				<th><?= $sortHelper('created', 'Created') ?></th>
				<th><?= $sortHelper('modified', 'Modified') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($products as $product) { ?>
				<tr>
					<td><?= h($product->title) ?></td>
					<td><span class="badge bg-success">$<?= number_format($product->price, 2) ?></span></td>
					<td><?= $this->Time->nice($product->created) ?></td>
					<td><?= $this->Time->nice($product->modified) ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="paginator">
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
		<a href="<?= $this->Url->build(['?' => ['sort' => 'created-desc']]) ?>" class="<?= $activeSort === 'created-desc' ? 'btn btn-sm btn-info' : 'btn btn-sm btn-outline-info' ?>">Newest First</a>
		<?php if ($activeSort === 'expensive-desc') { ?>
			<span class="btn btn-sm btn-warning">Most Expensive (Custom, Locked)</span>
		<?php } else { ?>
			<a href="<?= $this->Url->build(['?' => ['sort' => 'expensive-desc']]) ?>" class="btn btn-sm btn-outline-warning">Most Expensive (Custom, Locked)</a>
		<?php } ?>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'expensive-asc']]) ?>" class="btn btn-sm btn-outline-secondary text-decoration-line-through disabled" aria-disabled="true"><s>Expensive ASC</s></a>
	</div>

	<h3>Current Query Parameters</h3>
	<pre><?= h(print_r($this->request->getQuery(), true)) ?></pre>

	<h3>Implementation</h3>
	<pre><code class="language-php">// Controller - Using SortableFieldsBuilder (CakePHP 5.3)
$this->paginate = [
    'sortableFields' => function ($builder) {
        return $builder
            ->add('title')          // Allows: title-asc, title-desc
            // Lock price to ascending only (for demo purposes)
            ->add('price', SortField::asc('price', locked: true))
            ->add('created')        // Allows: created-asc, created-desc
            ->add('modified')
            // Custom multi-column sort: expensive items first (DESC only, locked)
            ->add('expensive', SortField::desc('price', locked: true), SortField::desc('created', locked: true));
    },
    'limit' => 10,
    'maxLimit' => 10,       // Enforce maximum limit
];

// Key Features Demonstrated:
// - Combined sort format: field-direction (e.g., title-asc)
// - Locked direction: price always sorts ASC, expensive always sorts DESC
// - Multi-column custom sort: 'expensive' sorts by price DESC, then created DESC
// - Pagination limit enforcement via maxLimit</code></pre>
</div>
