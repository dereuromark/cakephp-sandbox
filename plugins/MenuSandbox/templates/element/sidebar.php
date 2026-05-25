<?php
/**
 * Real-life collapsible sidebar built from the Menu model.
 *
 * We build a tree of real sandbox links, let the URL resolvers flag the active item,
 * then render Bootstrap 5 collapse markup ourselves so the branch holding the current
 * page auto-opens and its item is highlighted. This is the "drive your own UI from the
 * Menu model" recipe.
 *
 * @var \App\View\AppView $this
 */

use Menu\Item\ItemInterface;
use Menu\Menu;
use Menu\Resolver\Psr7UrlResolver;
use Menu\Resolver\ResolverCollection;
use Menu\Resolver\UrlArrayResolver;

$request = $this->getRequest();

$menu = Menu::create();
$menu->addItem('Dashboard', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);

$features = $menu->addItem('Menu features', '#', ['id' => 'features']);
$features->getSubMenu()->addItem('Resolvers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers']);
$features->getSubMenu()->addItem('Renderers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers']);
$features->getSubMenu()->addItem('Advanced', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced']);

$more = $menu->addItem('More sandboxes', '#', ['id' => 'more']);
$more->getSubMenu()->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index']);
$more->getSubMenu()->addItem('Auth Sandbox', ['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);
$more->getSubMenu()->addItem('Workflow Sandbox', ['plugin' => 'WorkflowSandbox', 'controller' => 'WorkflowSandbox', 'action' => 'index']);
$more->getSubMenu()->addItem('Plugin examples', ['plugin' => 'Sandbox', 'controller' => 'PluginExamples', 'action' => 'index']);

$menu->addItem('CakePHP Book', 'https://book.cakephp.org', ['attributes' => ['target' => '_blank', 'rel' => 'noopener']]);

$menu->resolve(
	(new ResolverCollection())
		->add(new UrlArrayResolver($request))
		->add(new Psr7UrlResolver($request)),
);

$hasActiveChild = static function (ItemInterface $item): bool {
	if (!$item->hasSubMenu()) {
		return false;
	}
	foreach ($item->getSubMenu()->getItems() as $child) {
		if ($child->isActive()) {
			return true;
		}
	}

	return false;
};

$renderItems = function (array $items) use (&$renderItems, $hasActiveChild): string {
	$html = '';
	foreach ($items as $item) {
		/** @var \Menu\Item\ItemInterface $item */
		if (!$item->isVisible()) {
			continue;
		}

		$label = h($item->getLabel());
		$link = $item->getLink();

		if ($item->hasSubMenu()) {
			$open = $hasActiveChild($item);
			$collapseId = 'menu-sb-' . h((string)$item->getId());
			$html .= '<li class="nav-item">';
			$html .= '<a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" role="button"'
				. ' href="#' . $collapseId . '" aria-expanded="' . ($open ? 'true' : 'false') . '" aria-controls="' . $collapseId . '">'
				. '<span>' . $label . '</span><span class="menu-caret">' . ($open ? '&#9662;' : '&#9656;') . '</span></a>';
			$html .= '<div class="collapse' . ($open ? ' show' : '') . '" id="' . $collapseId . '">';
			$html .= '<ul class="nav flex-column ms-3">' . $renderItems($item->getSubMenu()->getItems()) . '</ul>';
			$html .= '</div></li>';

			continue;
		}

		$active = $item->isActive();
		$attributes = $link ? $link->getAttributes() : [];
		$href = $link && $link->getUrl() !== null ? h($link->getUrl()) : '#';
		$target = isset($attributes['target']) ? ' target="' . h((string)$attributes['target']) . '" rel="noopener"' : '';
		$html .= '<li class="nav-item"><a class="nav-link' . ($active ? ' active' : '') . '" href="' . $href . '"'
			. ($active ? ' aria-current="page"' : '') . $target . '>' . $label . '</a></li>';
	}

	return $html;
};
?>

<div class="menu-sidebar">
	<h2 class="h5">Menu Sandbox</h2>
	<p>
		<a href="https://github.com/dereuromark/cakephp-menu" target="_blank" rel="noopener">[Menu Plugin]</a>
	</p>

	<ul class="nav flex-column border rounded p-2 mb-2">
		<?php echo $renderItems($menu->getItems()); ?>
	</ul>

	<p class="text-muted"><small>
		Collapsible sidebar driven by the Menu model + URL resolvers: the branch containing the current
		page opens automatically and its item is marked active.
	</small></p>
	<p class="text-muted"><small>
		Looking for an alternative? See <a href="https://github.com/icings/menu" target="_blank" rel="noopener">icings/menu</a>.
	</small></p>
</div>

<?php $this->append('css'); ?>
<style>
	.menu-sidebar .menu-caret { font-size: .8rem; opacity: .6; }
	.menu-sidebar .nav-link.active { font-weight: 600; }
</style>
<?php $this->end(); ?>
