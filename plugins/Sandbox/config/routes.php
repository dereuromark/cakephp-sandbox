<?php
/**
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Routing\RouteBuilder;

$routes->prefix('Admin', function (RouteBuilder $routes) {
	$routes->plugin('Sandbox', function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'Sandbox', 'action' => 'index']);

		$routes->fallbacks();
	});
});

$routes->plugin('Sandbox', function (RouteBuilder $routes) {
	$routes->connect('/', ['controller' => 'Sandbox', 'action' => 'index']);

	$routes->fallbacks();
});
