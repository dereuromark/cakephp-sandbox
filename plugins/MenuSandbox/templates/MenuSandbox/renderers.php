<?php
/**
 * @var \App\View\AppView $this
 */

use Menu\Link\Link;
use Menu\Renderer\Bootstrap5Renderer;
use Menu\Renderer\JsonRenderer;

/**
 * Builds the same little tree of real sandbox links fresh for each renderer.
 *
 * @param \App\View\AppView $view
 * @param string $name
 * @param string $menuClass
 * @return \Menu\MenuInterface
 */
$build = function ($view, string $name, string $menuClass = 'nav nav-pills') {
	$menu = $view->Menu->create($name, ['menuAttributes' => ['class' => $menuClass]]);
	$menu->addItem('Home', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
	$account = $menu->addItem('Account', '#');
	$account->getSubMenu()->addItem('Login', ['plugin' => false, 'controller' => 'Account', 'action' => 'login']);
	$account->getSubMenu()->addItem('Register', ['plugin' => false, 'controller' => 'Account', 'action' => 'register']);
	$menu->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index']);
	// External link: attributes belong on the <a>, so pass a Link (item `attributes` would land on the <li>).
	$menu->addItem('Book', Link::create('https://book.cakephp.org', ['target' => '_blank', 'rel' => 'noopener']));

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
	$build($this, 'bs_demo');
	echo $this->Menu->render('bs_demo', ['renderer' => Bootstrap5Renderer::class]);
	?>
	</nav>

	<pre><code>echo $this-&gt;Menu-&gt;render($menu, ['renderer' =&gt; \Menu\Renderer\Bootstrap5Renderer::class]);</code></pre>

	<h4 class="mt-4">JSON renderer</h4>
	<p>Serialize the tree for an API or a JS front-end (<code>['pretty' =&gt; true]</code> for readable output).</p>
	<?php
	$build($this, 'json_demo');
	$json = $this->Menu->render('json_demo', ['renderer' => JsonRenderer::class, 'pretty' => true]);
	?>
	<pre><code><?php echo h($json); ?></code></pre>

	<h4 class="mt-4">Per-render template override</h4>
	<p>Override individual templates inline, e.g. wrap the list in a <code>&lt;nav&gt;</code> element:</p>
	<?php
	$build($this, 'tpl_demo');
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

</div></div>

<?php $this->append('css'); ?>
<style>
	#content .custom-nav { border: 1px dashed var(--bs-border-color, #ccc); padding: .5rem; border-radius: .25rem; }
	.menu-tree,
	.menu-tree .submenu { list-style: none; padding-left: 0; margin-bottom: 0; }
	.menu-tree .submenu { margin-left: .5rem; padding-left: 1rem; border-left: 2px solid var(--bs-border-color, #dee2e6); }
	.menu-tree li > a { display: block; padding: .3rem .6rem; border-radius: .25rem; text-decoration: none; }
	.menu-tree li > a:hover { background: var(--bs-secondary-bg, #f1f3f5); }
	.menu-tree li.active > a { font-weight: 600; }
</style>
<?php $this->end(); ?>
