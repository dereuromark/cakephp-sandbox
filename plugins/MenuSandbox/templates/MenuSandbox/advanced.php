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

</div></div>
