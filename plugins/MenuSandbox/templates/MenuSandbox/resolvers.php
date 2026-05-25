<?php
/**
 * @var \App\View\AppView $this
 */

use Menu\Item\ItemInterface;
use Menu\Resolver\AuthorizationResolver;
use Menu\Resolver\CallbackResolver;
use Menu\Resolver\LoggedInResolver;
use Menu\Resolver\PermissionResolver;
use Menu\Resolver\Psr7UrlResolver;
use Menu\Resolver\ResolverCollection;
use Menu\Resolver\ResolverContext;
use Menu\Resolver\SectionResolver;
use Menu\Resolver\UrlArrayResolver;

$request = $this->getRequest();
$loggedIn = (bool)$request->getQuery('loggedIn');
$canAccessAdmin = (bool)$request->getQuery('admin');
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('sidebar'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Resolvers</h3>
	<p>
		Resolvers apply cross-cutting state (visibility, active, expanded) at render time, so the
		menu definition stays free of request/session/auth logic. All links below point at real sandbox pages.
	</p>

	<h4>Login visibility</h4>
	<p>
		Items tagged with <code>data['auth']</code> are shown/hidden by <code>LoggedInResolver</code>.
		Current state: <b><?php echo $loggedIn ? 'logged in' : 'logged out'; ?></b> &mdash;
		<?php echo $this->Html->link($loggedIn ? 'simulate log out' : 'simulate log in', ['action' => 'resolvers', '?' => $loggedIn ? [] : ['loggedIn' => 1]]); ?>.
	</p>

	<?php
	$auth = $this->Menu->create('auth', ['menuAttributes' => ['class' => 'nav nav-pills']]);
	$auth->addItem('Login', ['plugin' => false, 'controller' => 'Account', 'action' => 'login'], ['data' => ['auth' => 'loggedOut']]);
	$auth->addItem('Register', ['plugin' => false, 'controller' => 'Account', 'action' => 'register'], ['data' => ['auth' => 'loggedOut']]);
	$auth->addItem('Change password', ['plugin' => false, 'controller' => 'Account', 'action' => 'changePassword'], ['data' => ['auth' => 'loggedIn']]);
	$auth->addItem('Logout', ['plugin' => false, 'controller' => 'Account', 'action' => 'logout'], ['data' => ['auth' => 'loggedIn']]);
	echo $this->Menu->render('auth', ['resolver' => new LoggedInResolver($loggedIn)]);
	?>

	<pre><code>$menu-&gt;addItem('Login', '/login', ['data' =&gt; ['auth' =&gt; 'loggedOut']]);
$menu-&gt;addItem('Logout', '/logout', ['data' =&gt; ['auth' =&gt; 'loggedIn']]);
echo $this-&gt;Menu-&gt;render('auth', ['resolver' =&gt; new LoggedInResolver($identity !== null)]);</code></pre>

	<h4 class="mt-4">Section matching</h4>
	<p>
		<code>SectionResolver</code> marks an item active for a whole controller section, not just the exact
		URL. The first item stays active across every Menu Sandbox page (current section is
		<code><?php echo h((string)$request->getParam('controller')); ?></code>):
	</p>

	<?php
	$section = $this->Menu->create('section', ['menuAttributes' => ['class' => 'nav flex-column menu-demo-active']]);
	$section->addItem('Menu Sandbox (this section)', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index'], [
		'data' => ['section' => ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox']],
	]);
	$section->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index'], [
		'data' => ['section' => ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples']],
	]);
	echo $this->Menu->render('section', ['resolver' => new SectionResolver($request)]);
	?>

	<h4 class="mt-4">Alternate match routes</h4>
	<p>
		<code>matchRoutes</code> lets one item be active for several URLs. The item below links to the Menu
		Sandbox home but is also marked active on every Menu Sandbox sub-page — including this one:
	</p>

	<?php
	$alt = $this->Menu->create('alt', ['menuAttributes' => ['class' => 'nav nav-pills menu-demo-active']]);
	$alt->addItem('Menu Sandbox (any section)', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index'], [
		'matchRoutes' => [
			['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers'],
			['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers'],
			['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced'],
		],
	]);
	$alt->addItem('Reactions', ['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index']);
	echo $this->Menu->render('alt');
	?>

	<h4 class="mt-4">Authorization</h4>
	<p>
		<code>AuthorizationResolver</code> takes a callback returning <code>true</code>/<code>false</code> to
		toggle visibility (or <code>null</code> to leave an item untouched). Members area:
		<b><?php echo $canAccessAdmin ? 'granted' : 'denied'; ?></b> &mdash;
		<?php echo $this->Html->link($canAccessAdmin ? 'revoke' : 'grant', ['action' => 'resolvers', '?' => $canAccessAdmin ? [] : ['admin' => 1]]); ?>.
	</p>

	<?php
	$authz = $this->Menu->create('authz', ['menuAttributes' => ['class' => 'nav nav-pills']]);
	$authz->addItem('Overview', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
	$authz->addItem('Renderers (members only)', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers'], ['data' => ['permission' => 'menu.renderers']]);
	echo $this->Menu->render('authz', [
		'resolver' => new AuthorizationResolver(
			static function (ItemInterface $item, ResolverContext $context) use ($canAccessAdmin): ?bool {
				if ($item->getData('permission') === null) {
					return null;
				}

				return $canAccessAdmin;
			},
		),
	]);
	?>

	<h4 class="mt-4">Permission service</h4>
	<p>
		<code>PermissionResolver</code> bridges to an authorization service exposing a <code>can()</code> method
		(a tiny inline stub here). Items carry a <code>permission</code> key; denied ones are hidden:
	</p>

	<?php
	$authorizer = new class {

		/**
		 * @param string $permission
		 * @return bool
		 */
		public function can(string $permission): bool {
			return $permission === 'menu.public';
		}

	};
	$perm = $this->Menu->create('perm', ['menuAttributes' => ['class' => 'nav nav-pills']]);
	$perm->addItem('Public area', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index'], ['data' => ['permission' => 'menu.public']]);
	$perm->addItem('Secret area', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced'], ['data' => ['permission' => 'menu.secret']]);
	echo $this->Menu->render('perm', ['resolver' => new PermissionResolver($authorizer)]);
	?>
	<p class="text-muted"><small>"Secret area" is hidden because <code>can('menu.secret')</code> returns false.</small></p>

	<h4 class="mt-4">Custom callback</h4>
	<p><code>CallbackResolver</code> runs arbitrary logic per item with depth context. Here it appends a depth badge:</p>

	<?php
	$tree = $this->Menu->create('tree', ['menuAttributes' => ['class' => 'nav flex-column']]);
	$docs = $tree->addItem('Menu Sandbox', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
	$docs->getSubMenu()->addItem('Resolvers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers']);
	$advanced = $docs->getSubMenu()->addItem('Advanced', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced']);
	$advanced->getSubMenu()->addItem('Renderers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers']);
	echo $this->Menu->render('tree', [
		'resolver' => new CallbackResolver(
			static function (ItemInterface $item, ResolverContext $context): void {
				$item->setAfter(' <span class="badge bg-secondary">depth ' . $context->getDepth() . '</span>');
			},
		),
	]);
	?>

	<h4 class="mt-4">Combining resolvers</h4>
	<p>
		<code>ResolverCollection</code> chains several resolvers in one render, e.g. automatic URL active state
		plus login visibility:
	</p>

	<?php
	$combo = $this->Menu->create('combo', ['menuAttributes' => ['class' => 'nav nav-pills menu-demo-active']]);
	$combo->addItem('Overview', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);
	$combo->addItem('Resolvers', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers']);
	$combo->addItem('Members only', ['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced'], ['data' => ['auth' => 'loggedIn']]);
	echo $this->Menu->render('combo', [
		'resolver' => (new ResolverCollection())
			->add(new UrlArrayResolver($request))
			->add(new Psr7UrlResolver($request))
			->add(new LoggedInResolver($loggedIn)),
	]);
	?>
	<p class="text-muted"><small>The "Resolvers" item is active (current URL) and "Members only" only appears while logged in.</small></p>

</div></div>

<?php $this->append('css'); ?>
<style>
	#content .menu-demo-active li.active > a { font-weight: bold; }
</style>
<?php $this->end(); ?>
