<?php
/**
 * @var \App\View\AppView $this
 */

use Menu\Renderer\Bootstrap5Renderer;
use Menu\Renderer\JsonRenderer;

/**
 * Builds the same little tree of real sandbox links fresh for each renderer.
 *
 * @param \App\View\AppView $view
 * @param string $name
 * @return \Menu\MenuInterface
 */
$build = function ($view, string $name) {
	$menu = $view->Menu->create($name, ['menuAttributes' => ['class' => 'nav nav-pills']]);
	$menu->addItem('Home', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
	$account = $menu->addItem('Account', '#');
	$account->getSubMenu()->addItem('Login', ['plugin' => false, 'controller' => 'Account', 'action' => 'login']);
	$account->getSubMenu()->addItem('Register', ['plugin' => false, 'controller' => 'Account', 'action' => 'register']);
	$menu->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index']);
	$menu->addItem('Book', 'https://book.cakephp.org', ['attributes' => ['target' => '_blank', 'rel' => 'noopener']]);

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
	<p>Semantic nested <code>&lt;ul&gt;</code> markup with <code>aria-current</code> / <code>aria-expanded</code>.</p>
	<?php
	$build($this, 'default_demo');
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
</style>
<?php $this->end(); ?>
