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

// External link: `labelAttributes` (added in plugin #15) lands target/rel on the <a> — cleaner
// than passing a Link object just to carry the attributes.
$menu->addItem('CakePHP Book', 'https://book.cakephp.org', [
	'icon' => 'bi bi-book',
	'labelAttributes' => ['target' => '_blank', 'rel' => 'noopener'],
]);
?>

<div class="menu-sidebar">
	<h2 class="h5">Menu Sandbox</h2>
	<p>
		<a href="https://github.com/dereuromark/cakephp-menu" target="_blank" rel="noopener">[Menu Plugin]</a>
	</p>

	<?php
	// `toggleClass` defaults to `nav-link d-flex justify-content-between …` which pushes the caret
	// to the far edge and makes the toggle visually wider than the leaves. Plain `nav-link` keeps
	// the toggle in line with every other item, with the caret immediately after the label.
	// One chevron glyph for the caret; CSS rotates it on [aria-expanded="true"], so the indicator
	// stays in sync with Bootstrap's live collapse state.
	echo $this->Menu->render($menu, [
		'renderer' => Bootstrap5SidebarRenderer::class,
		'toggleClass' => 'nav-link',
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
	/* `transform` only takes visible effect on non-inline boxes; force inline-block so the chevron actually rotates on expand. */
	.menu-sidebar .menu-caret { font-size: .75rem; opacity: .55; transition: transform .15s ease; display: inline-block; }
	.menu-sidebar [aria-expanded="true"] .menu-caret { transform: rotate(90deg); }
	.menu-sidebar .nav-header { font-size: .75rem; text-transform: uppercase; opacity: .6; padding: .5rem .5rem .15rem; }
	/* Bootstrap's default .nav-link.active only shifts color (theme-dependent). Add weight + a subtle bg so the current page reads at a glance. */
	.menu-sidebar .nav-link.active { font-weight: 600; background: var(--bs-secondary-bg, #e9ecef); }
</style>
<?php $this->end(); ?>
