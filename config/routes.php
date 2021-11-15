<?php
/**
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/**
 * The default class to use for all routes
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
return static function (RouteBuilder $routes) {
	$routes->setRouteClass(DashedRoute::class);

	$routes->scope('/', function (RouteBuilder $routes) {

		$routes->connect('/', ['controller' => 'Overview', 'action' => 'index']);

		$routes->connect('/register', ['controller' => 'Account', 'action' => 'register']);
		$routes->connect('/login', ['controller' => 'Account', 'action' => 'login']);
		$routes->connect('/logout', ['controller' => 'Account', 'action' => 'logout']);

		//route to switch locale
		//$routes->connect('/lang/*', array('controller' => 'p28n', 'action' => 'change'));

		$routes->connect('/admin', ['prefix' => 'Admin', 'controller' => 'Overview', 'action' => 'index']);

		//$routes->connect('/translate', array('plugin' => 'Translate', 'controller' => 'TranslateGroups', 'action' => 'overview'));

		/**
		 * ...and connect the rest of 'Pages' controller's URLs.
		 */
		$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

		$routes->fallbacks();
	});

	$routes->prefix('Admin', function (RouteBuilder $routes) {
		// Because you are in the admin scope,
		// you do not need to include the /admin prefix
		// or the admin route element.
		$routes->fallbacks();
	});

	// TMP
	$routes->plugin('Data', function (RouteBuilder $routes) {
		// Because you are in the admin scope,
		// you do not need to include the /admin prefix
		// or the admin route element.
		$routes->fallbacks();
	});
};
