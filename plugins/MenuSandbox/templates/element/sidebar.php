<?php
/**
 * Real-life collapsible sidebar, rendered by the plugin's Bootstrap5SidebarRenderer.
 *
 * The menu is built once here (with first-class icons, a badge and non-link group headers);
 * the renderer resolves the active item, opens its branch and highlights it. Every link points
 * at a real sandbox page, so the active state changes as you navigate.
 *
 * @var \App\View\AppView $this
 */

use Menu\Link\Link;
use Menu\Menu;
use Menu\Renderer\Bootstrap5SidebarRenderer;

$menu = Menu::create();
$menu->addItem('Dashboard', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index'])
	->setIcon('bi bi-speedometer2');

$menu->addHeader('Menu features');
$menu->addItem('Resolvers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers'])
	->setIcon('bi bi-funnel');
$menu->addItem('Renderers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers'])
	->setIcon('bi bi-code-square');
$menu->addItem('Advanced', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced'])
	->setIcon('bi bi-gear');

$menu->addHeader('More sandboxes');
$menu->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index'])
	->setIcon('bi bi-emoji-smile')
	->setBadge('NEW', 'bg-success');

$explore = $menu->addItem('Explore', '#', ['id' => 'explore', 'icon' => 'bi bi-compass']);
$explore->getSubMenu()->addItem('Auth Sandbox', ['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);
$explore->getSubMenu()->addItem('Workflow Sandbox', ['plugin' => 'WorkflowSandbox', 'controller' => 'WorkflowSandbox', 'action' => 'index']);
$explore->getSubMenu()->addItem('Plugin examples', ['plugin' => 'Sandbox', 'controller' => 'PluginExamples', 'action' => 'index']);

// External link: attributes belong on the <a>, so pass a Link (item `attributes` would land on the <li>).
$menu->addItem('CakePHP Book', Link::create('https://book.cakephp.org', ['target' => '_blank', 'rel' => 'noopener']), ['icon' => 'bi bi-book']);
?>

<div class="menu-sidebar">
	<h2 class="h5">Menu Sandbox</h2>
	<p>
		<a href="https://github.com/dereuromark/cakephp-menu" target="_blank" rel="noopener">[Menu Plugin]</a>
	</p>

	<?php
	// A single chevron glyph for the caret; CSS rotates it when the branch is expanded
	// (Bootstrap toggles aria-expanded on click, so the indicator stays in sync).
	echo $this->Menu->render($menu, [
		'renderer' => Bootstrap5SidebarRenderer::class,
		'caretClosed' => '<i class="bi bi-chevron-right"></i>',
		'caretOpen' => '<i class="bi bi-chevron-right"></i>',
	]);
	?>

	<p class="text-muted"><small>
		Rendered by <code>Bootstrap5SidebarRenderer</code>: the branch holding the current page auto-opens
		and is highlighted, with first-class icons, a badge and non-link group headers.
	</small></p>
</div>

<?php $this->append('css'); ?>
<style>
	.menu-sidebar .menu-caret { font-size: .75rem; opacity: .55; transition: transform .15s ease; }
	.menu-sidebar [aria-expanded="true"] .menu-caret { transform: rotate(90deg); }
	.menu-sidebar .nav-header { font-size: .75rem; text-transform: uppercase; opacity: .6; padding: .5rem .5rem .15rem; }
</style>
<?php $this->end(); ?>
