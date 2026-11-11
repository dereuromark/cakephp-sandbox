<?php
/**
 * @var \App\View\AppView $this
 */

use CakeMenu\Renderer\Bootstrap5Renderer;
use CakeMenu\Renderer\Bootstrap5SidebarRenderer;
use CakeMenu\Renderer\JsonRenderer;

/**
 * Builds the same little tree of real sandbox links fresh for each renderer.
 *
 * @param \App\View\AppView $view
 * @param string $name
 * @param string $menuClass
 * @return \CakeMenu\MenuInterface
 */
$build = function ($view, string $name, string $menuClass = 'nav nav-pills') {
	$menu = $view->Menu->create($name, ['attributes' => ['class' => $menuClass]]);
	$menu->addItem('Home', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
	$account = $menu->addItem('Account', '#');
	$account->getSubMenu()->addItem('Login', ['plugin' => false, 'controller' => 'Account', 'action' => 'login']);
	$account->getSubMenu()->addItem('Register', ['plugin' => false, 'controller' => 'Account', 'action' => 'register']);
	$menu->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index']);
	// External link: `labelAttributes` puts target/rel on the rendered <a> — works in StringTemplate,
	// Bootstrap5 and Sidebar renderers without needing a Link object just to carry the attributes.
	$menu->addItem('Book', 'https://book.cakephp.org', [
		'labelAttributes' => ['target' => '_blank', 'rel' => 'noopener'],
	]);

	return $menu;
};
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('sidebar'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Renderers</h3>
	<p>The same menu can be rendered by different renderers without changing how it is built.</p>

	<h4>Default (string template) renderer</h4>
	<p>
		Framework-agnostic, semantic nested <code>&lt;ul&gt;</code> markup with <code>aria-current</code> /
		<code>aria-expanded</code> &mdash; styled here with a few lines of CSS:
	</p>
	<?php
	$build($this, 'default_demo', 'menu-tree');
	echo $this->Menu->render('default_demo');
	?>

	<h4 class="mt-4">Bootstrap 5 renderer</h4>
	<p>Emits Bootstrap navbar/dropdown markup (the Account branch becomes a dropdown).</p>
	<nav class="navbar navbar-expand bg-body-tertiary border rounded px-3">
	<?php
	$build($this, 'bs_demo', 'navbar-nav');
	echo $this->Menu->render('bs_demo', ['renderer' => Bootstrap5Renderer::class]);
	?>
	</nav>

	<pre><code>echo $this-&gt;Menu-&gt;render($menu, ['renderer' =&gt; \CakeMenu\Renderer\Bootstrap5Renderer::class]);</code></pre>

	<h4 class="mt-4">JSON renderer</h4>
	<p>Serialize the tree for an API or a JS front-end (<code>['pretty' =&gt; true]</code> for readable output).</p>
	<?php
	$build($this, 'json_demo');
	$json = $this->Menu->render('json_demo', ['renderer' => JsonRenderer::class, 'pretty' => true]);
	?>
	<pre class="menu-json"><code><?php echo h($json); ?></code></pre>

	<h4 class="mt-4">Per-render template override</h4>
	<p>Override individual templates inline, e.g. wrap the list in a <code>&lt;nav&gt;</code> element:</p>
	<?php
	$build($this, 'tpl_demo', 'menu-tree');
	echo $this->Menu->render('tpl_demo', [
		'templates' => [
			'menuWrapper' => '<nav class="custom-nav"><ul{{attributes}}>{{items}}</ul></nav>',
		],
	]);
	?>

	<pre><code>echo $this-&gt;Menu-&gt;render($menu, [
    'templates' =&gt; [
        'menuWrapper' =&gt; '&lt;nav&gt;&lt;ul{{attributes}}&gt;{{items}}&lt;/ul&gt;&lt;/nav&gt;',
    ],
]);</code></pre>


	<h4 class="mt-4">Where the active class goes (<code>activeOn</code>)</h4>
	<p>
		<code>activeOn</code> puts the active/ancestor classes on the <code>&lt;li&gt;</code> (<code>item</code>, the default),
		on the link (<code>link</code>, what Bootstrap and most utility CSS expect), or on <code>both</code>.
		The <code>Bootstrap5Renderer</code> defaults to <code>link</code>, so <code>.nav-link.active</code> lights up.
	</p>
	<?php
	$activeDemo = function ($view, string $name) {
		$menu = $view->Menu->create($name, ['attributes' => ['class' => 'nav nav-pills']]);
		$menu->addItem('Home', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
		$menu->addItem('Renderers (this page)', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers']);

		return $menu;
	};
	foreach (['item', 'link', 'both'] as $activeOn) {
		$activeDemo($this, 'active_on_' . $activeOn);
		$html = $this->Menu->render('active_on_' . $activeOn, ['activeOn' => $activeOn]);
		echo '<p class="mb-1 mt-2"><code>activeOn =&gt; \'' . $activeOn . '\'</code>:</p>';
		echo '<pre><code>' . h($html) . '</code></pre>';
	}
	?>

	<h4 class="mt-4">Trusted icon markup</h4>
	<p>
		Icons and badges are escaped by default; the default <code>iconTemplate</code> turns an icon class into an
		<code>&lt;i&gt;</code> tag. For your own markup (icon fonts, SVG), opt out per item with
		<code>escapeIcon =&gt; false</code> (or <code>setIcon($html, false)</code>) and put <code>{{icon}}</code> in a
		text position of the template. On CakePHP 5.next, values created with <code>html()</code> skip escaping
		without the flag.
	</p>
	<?php
	$icons = $this->Menu->create('icon_demo', ['attributes' => ['class' => 'nav nav-pills']]);
	$icons->addItem('Class name', '#', ['icon' => 'bi bi-house']);
	echo $this->Menu->render('icon_demo', ['renderer' => Bootstrap5Renderer::class]);
	?>
	<p class="mb-1 mt-2">With the default template the raw markup would end up inside <code>class="..."</code>, so render it with an <code>iconTemplate</code> that places <code>{{icon}}</code> as text:</p>
	<?php
	$own = $this->Menu->create('icon_demo_own', ['attributes' => ['class' => 'nav nav-pills']]);
	$own->addItem('Own markup', '#', [
		'icon' => '<i class="bi bi-stars text-warning" aria-hidden="true"></i>',
		'escapeIcon' => false,
	]);
	echo $this->Menu->render('icon_demo_own', ['renderer' => Bootstrap5Renderer::class, 'iconTemplate' => '{{icon}} ']);
	?>

	<pre><code>$menu-&gt;addItem('Own markup', '#', [
    'icon' =&gt; '&lt;i class="bi bi-stars" aria-hidden="true"&gt;&lt;/i&gt;',
    'escapeIcon' =&gt; false,
]);
echo $this-&gt;Menu-&gt;render($menu, ['iconTemplate' =&gt; '{{icon}} ']);</code></pre>

	<h4 class="mt-4">Sidebar depth and toggle label</h4>
	<p>
		The sidebar renderer honors <code>depth</code> (here: top level only, branches render as plain links).
		A branch that links somewhere gets a separate caret button; <code>toggleLabel</code> sets that button's
		accessible name (a <code>sprintf()</code> format, so it can be translated with <code>__()</code>).
	</p>
	<p class="mb-1"><code>depth =&gt; 1</code>:</p>
	<?php
	$build($this, 'sidebar_depth_demo', 'nav flex-column');
	echo $this->Menu->render('sidebar_depth_demo', [
		'renderer' => Bootstrap5SidebarRenderer::class,
		'depth' => 1,
	]);
	echo '<p class="mb-1 mt-3"><code>toggleLabel =&gt; __(\'Show %s\')</code> (the caret button is named "Show Menu Sandbox"):</p>';
	$labelDemo = $this->Menu->create('sidebar_label_demo', ['attributes' => ['class' => 'nav flex-column']]);
	$sandbox = $labelDemo->addItem('Menu Sandbox', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
	$sandbox->getSubMenu()->addItem('Advanced', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced']);
	$sidebarHtml = $this->Menu->render('sidebar_label_demo', [
		'renderer' => Bootstrap5SidebarRenderer::class,
		'toggleLabel' => __('Show %s'),
		'idPrefix' => 'label-demo-',
	]);
	echo $sidebarHtml;
	?>

	<pre><code>echo $this-&gt;Menu-&gt;render($menu, [
    'renderer' =&gt; Bootstrap5SidebarRenderer::class,
    'depth' =&gt; 1,
]);
echo $this-&gt;Menu-&gt;render($menu, [
    'renderer' =&gt; Bootstrap5SidebarRenderer::class,
    'toggleLabel' =&gt; __('Show %s'),
]);</code></pre>
</div></div>

<?php $this->append('css'); ?>
<style>
	.custom-nav { border: 1px dashed var(--bs-border-color, #ccc); padding: .5rem; border-radius: .25rem; }
	.menu-tree,
	.menu-tree .submenu { list-style: none; padding-left: 0; margin-bottom: 0; }
	.menu-tree .submenu { margin-left: .5rem; padding-left: 1rem; border-left: 2px solid var(--bs-border-color, #dee2e6); }
	.menu-tree li > a { display: block; padding: .3rem .6rem; border-radius: .25rem; text-decoration: none; }
	.menu-tree li > a:hover { background: var(--bs-secondary-bg, #f1f3f5); }
	.menu-tree li.active > a { font-weight: 600; }
	.page pre { white-space: pre-wrap; word-break: break-word; margin-top: .75rem; }
	.page pre.menu-json { max-height: 20rem; overflow: auto; border: 1px solid var(--bs-border-color, #dee2e6); border-radius: .25rem; padding: .5rem; }
</style>
<?php $this->end(); ?>
