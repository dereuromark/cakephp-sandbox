<?php
/**
 * @var \App\View\AppView $this
 */

use Menu\Menu;
use Menu\Renderer\BreadcrumbRenderer;
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('sidebar'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Advanced</h3>

	<h4>Breadcrumbs from a menu</h4>
	<p>
		The active item's path becomes a breadcrumb trail. The menu below has a
		<i>Menu Sandbox &rsaquo; Advanced</i> branch and we are on the <b>Advanced</b> page, so:
	</p>

	<?php
	$this->Menu->register('docs', static function ($menu): void {
		$builder = $menu->addItem('Menu Sandbox', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
		$builder->getSubMenu()->addItem('Advanced', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced']);
	});
	?>

	<p><b>Via the core Breadcrumbs helper:</b></p>
	<?php echo $this->Menu->renderBreadcrumbs('docs'); ?>

	<p class="mt-3"><b>Via the built-in breadcrumb renderer:</b></p>
	<?php echo $this->Menu->renderBreadcrumbs('docs', ['renderer' => BreadcrumbRenderer::class]); ?>

	<pre><code>$this-&gt;Menu-&gt;register('docs', function ($menu) {
    $node = $menu-&gt;addItem('Menu Sandbox', ['controller' =&gt; 'MenuSandbox', 'action' =&gt; 'index']);
    $node-&gt;getSubMenu()-&gt;addItem('Advanced', ['controller' =&gt; 'MenuSandbox', 'action' =&gt; 'advanced']);
});
echo $this-&gt;Menu-&gt;renderBreadcrumbs('docs');</code></pre>

	<h4 class="mt-4">Array import / export</h4>
	<p>Define a whole tree as data with <code>Menu::fromArray()</code> and serialize it back with <code>toArray()</code>.</p>

	<?php
	$imported = Menu::fromArray([
		'attributes' => ['class' => 'nav nav-pills'],
		'items' => [
			['id' => 'home', 'label' => 'Home', 'link' => '/menu-sandbox'],
			[
				'id' => 'sandboxes',
				'label' => 'Sandboxes',
				'link' => '#',
				'submenu' => [
					'items' => [
						['label' => 'Reactions', 'link' => '/sandbox/reaction-examples'],
						['label' => 'Workflow', 'link' => '/workflow-sandbox'],
					],
				],
			],
		],
	]);
	echo $this->Menu->render($imported);
	$export = $imported->toArray();
	?>

	<p class="mt-2"><code>toArray()</code> output:</p>
	<pre><code><?php echo h(json_encode($export, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)); ?></code></pre>

	<h4 class="mt-4">Build from flat rows</h4>
	<p>
		<code>Menu::fromFlat()</code> turns a flat list of records (e.g. database rows with a parent reference)
		into a tree. The mapper returns a <code>key</code>, optional <code>parent</code> key, <code>label</code>
		and <code>link</code>; rows may arrive in any order and children are attached once all rows are read.
	</p>

	<?php
	// Pretend these came from a `menu_items` table (id / parent_id / title / url).
	$rows = [
		['id' => 1, 'parent_id' => null, 'title' => 'Menu Sandbox', 'url' => '/menu-sandbox'],
		['id' => 2, 'parent_id' => 1, 'title' => 'Resolvers', 'url' => '/menu-sandbox/resolvers'],
		['id' => 3, 'parent_id' => 1, 'title' => 'Advanced', 'url' => '/menu-sandbox/advanced'],
		['id' => 4, 'parent_id' => 3, 'title' => 'Renderers', 'url' => '/menu-sandbox/renderers'],
		['id' => 5, 'parent_id' => null, 'title' => 'Reactions', 'url' => '/sandbox/reaction-examples'],
	];
	$tree = Menu::fromFlat($rows, static fn (array $row): array => [
		'key' => (string)$row['id'],
		'parent' => $row['parent_id'] !== null ? (string)$row['parent_id'] : null,
		'label' => $row['title'],
		'link' => $row['url'],
	]);
	echo $this->Menu->render($tree);
	?>

	<pre><code>$tree = Menu::fromFlat($rows, fn (array $row) =&gt; [
    'key' =&gt; (string)$row['id'],
    'parent' =&gt; $row['parent_id'] !== null ? (string)$row['parent_id'] : null,
    'label' =&gt; $row['title'],
    'link' =&gt; $row['url'],
]);</code></pre>

	<h4 class="mt-4">Flatten &amp; look up</h4>
	<p>
		<code>collect()</code> flattens the whole tree (depth-first) into an <code>ItemCollection</code> you can
		count and search &mdash; handy for "find this node anywhere in the tree" without recursing yourself.
	</p>

	<?php
	$collection = $tree->collect();
	$renderersItem = $collection->findByKey('4');
	$docsChildren = $collection->findByParent($collection->findByKey('1'));
	$childLabels = array_map(static fn ($item) => (string)$item->getLabel(), $docsChildren);
	?>
	<ul>
		<li><code>count()</code>: the tree above flattens to <b><?php echo $collection->count(); ?></b> items.</li>
		<li><code>findByKey('4')</code>: <b><?php echo h($renderersItem ? (string)$renderersItem->getLabel() : '(none)'); ?></b>.</li>
		<li><code>findByParent()</code> of "Menu Sandbox": <b><?php echo h($childLabels ? implode(', ', $childLabels) : '(none)'); ?></b>.</li>
	</ul>

	<h4 class="mt-4">Freeze mode</h4>
	<p>
		<code>freeze()</code> locks the structure. Resolvers may still flip runtime state (active/visible/expanded),
		but structural changes throw a <code>LogicException</code>.
	</p>

	<?php
	$frozen = Menu::fromArray([
		'attributes' => ['class' => 'nav nav-pills'],
		'items' => [
			['label' => 'Read only', 'link' => '/menu-sandbox'],
			['label' => 'Locked', 'link' => '/menu-sandbox/advanced'],
		],
	])->freeze();

	$freezeError = null;
	try {
		$frozen->addItem('Should fail', '/nope');
	} catch (LogicException $exception) {
		$freezeError = $exception->getMessage();
	}

	echo $this->Menu->render($frozen);
	?>
	<p class="mt-2">Attempting to add an item after freezing: <code><?php echo h((string)$freezeError); ?></code></p>

	<h4 class="mt-4">Tree manipulation</h4>
	<p>
		<code>insertBefore()</code> / <code>insertAfter()</code> / <code>moveToPosition()</code> / <code>reorder()</code>
		mutate the menu in place; <code>slice()</code> / <code>split()</code> / <code>merge()</code> return derived
		working copies via deep <code>__clone</code>, so the source tree stays intact and re-renderable.
	</p>

	<?php
	$source = Menu::create(['class' => 'nav nav-pills']);
	$source->addItem('Home', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index'], ['key' => 'home']);
	$source->addItem('Resolvers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers'], ['key' => 'resolvers']);
	$source->addItem('Renderers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers'], ['key' => 'renderers']);
	$source->addItem('Advanced', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced'], ['key' => 'advanced']);

	$reordered = clone $source;
	$reordered->reorder(['advanced', 'home', 'renderers', 'resolvers']);

	$firstTwo = $source->slice(0, 2);
	$lastTwo = $source->slice(2);

	$merged = (clone $firstTwo)->merge($lastTwo);
	$merged->insertBefore($merged->newItem('NEW', 'https://github.com/dereuromark/cakephp-menu', [
		'key' => 'github',
		'labelAttributes' => ['target' => '_blank', 'rel' => 'noopener'],
	]), 'advanced');
	?>

	<p class="mb-1"><b>Source</b> (unchanged after all of the operations below):</p>
	<?php echo $this->Menu->render($source); ?>

	<p class="mb-1 mt-3"><b><code>clone</code> + <code>reorder()</code></b> (mutates the working copy only):</p>
	<?php echo $this->Menu->render($reordered); ?>

	<p class="mb-1 mt-3"><b><code>slice(0, 2)</code></b>:</p>
	<?php echo $this->Menu->render($firstTwo); ?>

	<p class="mb-1 mt-3"><b><code>merge()</code> + <code>insertBefore()</code></b> (adds a GitHub link before <code>advanced</code>):</p>
	<?php echo $this->Menu->render($merged); ?>

	<pre><code>$reordered = clone $source;
$reordered-&gt;reorder(['advanced', 'home', 'renderers', 'resolvers']);

$firstTwo = $source-&gt;slice(0, 2);              // new menu, items deep-cloned
$merged = (clone $firstTwo)-&gt;merge($lastTwo);   // also a new menu, source untouched
$merged-&gt;insertBefore($merged-&gt;newItem('NEW', '...'), 'advanced');</code></pre>

	<h4 class="mt-4">Bulk add &amp; lookup by key</h4>
	<p>
		<code>addItems()</code> validates the whole batch first (type + id/key uniqueness across the batch
		and the tree) and rejects the lot atomically on the first conflict. Then look items up by their
		stable <code>key</code> with <code>getByKey()</code> / <code>hasKey()</code>, and search the entire
		tree recursively with <code>find(callable)</code>.
	</p>

	<?php
	$bulk = Menu::create(['class' => 'nav flex-column']);
	$bulk->addItems([
		$bulk->newItem('Overview', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index'], ['key' => 'overview']),
		$bulk->newItem('Features', '#', ['key' => 'features']),
		$bulk->newItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index'], ['key' => 'reactions']),
	]);
	$bulk->getByKey('features')->getSubMenu()->addItems([
		$bulk->newItem('Resolvers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers'], ['key' => 'features.resolvers']),
		$bulk->newItem('Renderers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers'], ['key' => 'features.renderers']),
	]);

	$matches = $bulk->find(static fn ($item) => str_starts_with($item->getKey(), 'features.'));
	$matchLabels = array_map(static fn ($item) => (string)$item->getLabel(), $matches->all());

	$bulkError = null;
	try {
		// Same key as the existing 'overview' item → whole batch rejected (atomic).
		$bulk->addItems([$bulk->newItem('Conflict', '/whatever', ['key' => 'overview'])]);
	} catch (\InvalidArgumentException $exception) {
		$bulkError = $exception->getMessage();
	}
	?>
	<?php echo $this->Menu->render($bulk); ?>
	<ul>
		<li><code>hasKey('reactions')</code>: <b><?php echo $bulk->hasKey('reactions') ? 'true' : 'false'; ?></b></li>
		<li><code>getByKey('features')-&gt;getLabel()</code>: <b><?php echo h((string)$bulk->getByKey('features')->getLabel()); ?></b></li>
		<li><code>find(fn ($i) =&gt; str_starts_with($i-&gt;getKey(), 'features.'))</code>: <b><?php echo h($matchLabels ? implode(', ', $matchLabels) : '(none)'); ?></b></li>
		<li><code>addItems()</code> with a key conflict (atomic rejection): <code><?php echo h((string)$bulkError); ?></code></li>
	</ul>

</div></div>
