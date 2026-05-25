<?php
/**
 * @var \App\View\AppView $this
 */

use Menu\Renderer\Bootstrap5Renderer;

$navbar = $this->Menu->create('navbar', ['menuAttributes' => ['class' => 'navbar-nav me-auto']]);
$navbar->addItem('Home', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
$nbFeatures = $navbar->addItem('Features', '#', ['id' => 'nav-features']);
$nbFeatures->getSubMenu()->addItem('Resolvers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers']);
$nbFeatures->getSubMenu()->addItem('Renderers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers']);
$nbFeatures->getSubMenu()->addItem('Advanced', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced']);
$nbFeatures->getSubMenu()->addDivider();
$nbFeatures->getSubMenu()->addItem('Plugin on GitHub', 'https://github.com/dereuromark/cakephp-menu', ['attributes' => ['target' => '_blank', 'rel' => 'noopener']]);
$navbar->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index']);
$navbar->addItem('CakePHP Book', 'https://book.cakephp.org', ['attributes' => ['target' => '_blank', 'rel' => 'noopener']]);

// "You are here": resolve the active item and walk its ancestor path.
$current = $this->Menu->getCurrentItem('navbar');
$trail = $current ? array_map(static fn ($i) => (string)$i->getLabel(), $this->Menu->extractPath($current)) : [];
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('sidebar'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Real-life navigation</h3>
	<p>
		The same menu library powers both a top navigation bar and the collapsible sidebar on the left.
		Every link points at a real page in this sandbox, the active item is detected automatically from
		the current URL, and submenus fold open/closed. Click around &mdash; the sidebar keeps the branch
		of the page you are on expanded and highlighted.
	</p>

	<h4>Top navbar (Bootstrap 5 renderer)</h4>
	<p>The built-in <code>Bootstrap5Renderer</code> emits ready-to-use navbar + dropdown markup:</p>

	<nav class="navbar navbar-expand bg-body-tertiary border rounded px-3 mb-3">
		<?php echo $this->Menu->render('navbar', ['renderer' => Bootstrap5Renderer::class]); ?>
	</nav>

	<p class="text-muted">
		<small>
			The dropdown ends with a divider (<code>addDivider()</code>) before the external link.
			Via <code>getCurrentItem()</code> + <code>extractPath()</code> the active trail is:
			<b><?php echo $trail ? h(implode(' › ', $trail)) : __('(none)'); ?></b>.
		</small>
	</p>

	<pre><code>$navbar = $this-&gt;Menu-&gt;create('navbar', ['menuAttributes' =&gt; ['class' =&gt; 'navbar-nav']]);
$navbar-&gt;addItem('Home', ['controller' =&gt; 'MenuSandbox', 'action' =&gt; 'index']);
$features = $navbar-&gt;addItem('Features', '#');
$features-&gt;getSubMenu()-&gt;addItem('Resolvers', ['controller' =&gt; 'MenuSandbox', 'action' =&gt; 'resolvers']);
echo $this-&gt;Menu-&gt;render('navbar', ['renderer' =&gt; \Menu\Renderer\Bootstrap5Renderer::class]);</code></pre>

	<h4>Collapsible sidebar (custom render)</h4>
	<p>
		The left sidebar is built from the same <code>Menu</code> model: we apply the URL resolvers to flag
		the active item, then render Bootstrap <code>collapse</code> markup so the active branch auto-opens.
		See <code>templates/element/sidebar.php</code> for the ~40 lines that do it.
	</p>

	<h4>Explore the features</h4>
	<ul>
		<li><?php echo $this->Html->link('Resolvers', ['action' => 'resolvers']); ?> &mdash; active state &amp; visibility from request/auth</li>
		<li><?php echo $this->Html->link('Renderers', ['action' => 'renderers']); ?> &mdash; list / Bootstrap 5 / JSON output</li>
		<li><?php echo $this->Html->link('Advanced', ['action' => 'advanced']); ?> &mdash; breadcrumbs, import/export, freeze</li>
	</ul>

</div></div>
