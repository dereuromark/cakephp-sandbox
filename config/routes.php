<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {

	$routes->connect('/', ['controller' => 'Overview', 'action' => 'index']);

	$routes->connect('/register', ['controller' => 'Account', 'action' => 'register']);
	$routes->connect('/login', ['controller' => 'Account', 'action' => 'login']);
	$routes->connect('/logout', ['controller' => 'Account', 'action' => 'logout']);

	//route to switch locale
	//$routes->connect('/lang/*', array('controller' => 'p28n', 'action' => 'change'));

	$routes->connect('/admin', ['prefix' => 'admin', 'controller' => 'Overview', 'action' => 'index']);

	//$routes->connect('/translate', array('plugin' => 'translate', 'controller' => 'translate_groups', 'action' => 'overview'));

	/**
	 * ...and connect the rest of 'Pages' controller's URLs.
	 */
	$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

	$routes->fallbacks();
});

Router::prefix('admin', function (RouteBuilder $routes) {
	// Because you are in the admin scope,
	// you do not need to include the /admin prefix
	// or the admin route element.
	$routes->fallbacks();
});
