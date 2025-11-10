<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxPost[]|\Cake\Collection\CollectionInterface $posts
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
			<li><code><?= $this->Url->build(['?' => ['sort' => 'created-desc']]) ?></code> - Sort by created descending</li>
			<li><code><?= $this->Url->build(['?' => ['sort' => 'rating_count-desc,created-desc']]) ?></code> - Multi-column combined sort</li>
		</ul>
	</div>

	<?php
	$currentSort = $this->request->getQuery('sort');
	$sortHelper = function ($field, $label = null) use ($currentSort) {
		$label = $label ?: ucfirst($field);
		$isAsc = $currentSort === $field . '.asc';
		$isDesc = $currentSort === $field . '.desc';
		$nextSort = $isAsc ? $field . '.desc' : $field . '.asc';

		$arrow = '';
		if ($isAsc) {
			$arrow = ' ▲';
		} elseif ($isDesc) {
			$arrow = ' ▼';
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
				<th><?= $sortHelper('rating_count', 'Rating Count') ?></th>
				<th><?= $sortHelper('rating_sum', 'Rating Sum') ?></th>
				<th><?= $sortHelper('created', 'Created') ?></th>
				<th><?= $sortHelper('modified', 'Modified') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($posts as $post) { ?>
				<tr>
					<td><?= h($post->title) ?></td>
					<td><span class="badge bg-info"><?= $post->rating_count ?? 0 ?></span></td>
					<td><span class="badge bg-primary"><?= $post->rating_sum ?? 0 ?></span></td>
					<td><?= $post->created->nice() ?></td>
					<td><?= $post->modified->nice() ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="paginator">
		<?= $this->element('Tools.pagination') ?>
	</div>

	<h3>Try Combined Sort</h3>
	<div class="mb-3">
		<a href="<?= $this->Url->build(['?' => ['sort' => 'title-asc']]) ?>" class="btn btn-sm btn-outline-primary">Title ASC</a>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'title-desc']]) ?>" class="btn btn-sm btn-outline-primary">Title DESC</a>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'rating_count-desc']]) ?>" class="btn btn-sm btn-outline-success">Rating Count DESC</a>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'rating_sum-desc']]) ?>" class="btn btn-sm btn-outline-success">Rating Sum DESC</a>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'created-desc']]) ?>" class="btn btn-sm btn-outline-info">Created DESC</a>
		<a href="<?= $this->Url->build(['?' => ['sort' => 'rating_count-desc,created-desc']]) ?>" class="btn btn-sm btn-outline-warning">Rating DESC + Created DESC</a>
	</div>

	<h3>Current Query Parameters</h3>
	<pre><?= h(print_r($this->request->getQuery(), true)) ?></pre>

	<h3>Implementation</h3>
	<pre><code class="language-php">// Controller - Using SortableFieldsBuilder (CakePHP 5.3)
$this->paginate = [
    'sortableFields' => function ($builder) {
        return $builder
            ->add('title')           // Allows: title-asc, title-desc
            ->add('rating_count')    // Allows: rating_count-asc, rating_count-desc
            ->add('created')         // Allows: created-asc, created-desc
            ->add('modified');
    },
    'limit' => 10,
];

// The builder automatically creates -asc and -desc variants
// Example URLs:
// - ?sort=title-asc
// - ?sort=rating_count-desc
// - ?sort=rating_count-desc,created-desc  (multi-column)</code></pre>
</div>
