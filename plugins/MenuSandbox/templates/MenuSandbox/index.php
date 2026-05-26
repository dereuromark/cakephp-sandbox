<?php
/**
 * @var \App\View\AppView $this
 */

use Menu\Link\Link;
use Menu\Renderer\NavbarRenderer;

$navbar = $this->Menu->create('navbar', ['menuAttributes' => ['class' => 'navbar-nav me-auto']]);
$navbar->addItem('Home', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index'], ['icon' => 'bi bi-house']);
$nbFeatures = $navbar->addItem('Features', '#', ['id' => 'nav-features', 'icon' => 'bi bi-stars']);
$nbFeatures->getSubMenu()->addItem('Resolvers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers']);
$nbFeatures->getSubMenu()->addItem('Renderers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers']);
$nbFeatures->getSubMenu()->addItem('Advanced', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced']);
$nbFeatures->getSubMenu()->addDivider();
$nbFeatures->getSubMenu()->addItem('Plugin on GitHub', Link::create('https://github.com/dereuromark/cakephp-menu', ['target' => '_blank', 'rel' => 'noopener']));
$navbar->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index'], ['icon' => 'bi bi-emoji-smile', 'badge' => 'NEW', 'badgeType' => 'bg-success']);
$navbar->addItem('CakePHP Book', Link::create('https://book.cakephp.org', ['target' => '_blank', 'rel' => 'noopener']), ['icon' => 'bi bi-book']);

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

	<h4>Top navbar (NavbarRenderer)</h4>
	<p>
		<code>NavbarRenderer</code> emits the <em>complete</em> Bootstrap 5 navbar &mdash; the <code>&lt;nav&gt;</code> landmark,
		brand, responsive toggler and the collapsible <code>navbar-nav</code> with dropdowns &mdash; from one menu
		definition. Items carry first-class icons and badges (<code>icon</code> / <code>badge</code> options):
	</p>

	<?php
	echo $this->Menu->render('navbar', [
		'renderer' => NavbarRenderer::class,
		'brand' => 'Menu Sandbox',
		'brandUrl' => $this->Url->build(['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']),
		'collapseId' => 'menu-sandbox-navbar',
		'ariaLabel' => 'Main navigation',
		'navbarClass' => 'navbar navbar-expand-lg bg-body-tertiary border rounded px-3 mb-3',
	]);
	?>

	<p class="text-muted">
		<small>
			The dropdown ends with a divider (<code>addDivider()</code>) before the external link.
			Via <code>getCurrentItem()</code> + <code>extractPath()</code> the active trail is:
			<b><?php echo $trail ? h(implode(' › ', $trail)) : __('(none)'); ?></b>.
		</small>
	</p>

	<pre><code>$navbar = $this-&gt;Menu-&gt;create('navbar', ['menuAttributes' =&gt; ['class' =&gt; 'navbar-nav']]);
$navbar-&gt;addItem('Home', ['controller' =&gt; 'MenuSandbox', 'action' =&gt; 'index'], ['icon' =&gt; 'bi bi-house']);
$reactions = $navbar-&gt;addItem('Reactions', '/sandbox/reaction-examples', ['icon' =&gt; 'bi bi-emoji-smile', 'badge' =&gt; 'NEW', 'badgeType' =&gt; 'bg-success']);
echo $this-&gt;Menu-&gt;render('navbar', ['renderer' =&gt; \Menu\Renderer\NavbarRenderer::class, 'brand' =&gt; 'Menu Sandbox']);</code></pre>

	<h4>Collapsible sidebar (Bootstrap5SidebarRenderer)</h4>
	<p>
		The left sidebar is built from the same <code>Menu</code> model and rendered by
		<code>Bootstrap5SidebarRenderer</code>: the URL resolvers flag the active item, the renderer emits
		Bootstrap <code>collapse</code> markup so the active branch auto-opens, and items show icons,
		a badge and non-link group headers (<code>addHeader()</code>). See <code>templates/element/sidebar.php</code>.
	</p>

	<h4>Explore the features</h4>
	<ul>
		<li><?php echo $this->Html->link('Resolvers', ['action' => 'resolvers']); ?> &mdash; active state &amp; visibility from request/auth</li>
		<li><?php echo $this->Html->link('Renderers', ['action' => 'renderers']); ?> &mdash; list / Bootstrap 5 / JSON output</li>
		<li><?php echo $this->Html->link('Advanced', ['action' => 'advanced']); ?> &mdash; breadcrumbs, import/export, freeze</li>
	</ul>

</div></div>
