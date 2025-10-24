<?php
/**
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Routing\RouteBuilder;

$routes->prefix('Admin', function (RouteBuilder $routes) {
	$routes->plugin('AuthSandbox', ['path' => '/auth-sandbox'], function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'AuthSandbox', 'action' => 'index']);

		$routes->fallbacks();
	});
});

$routes->plugin('AuthSandbox', ['path' => '/auth-sandbox'], function (RouteBuilder $routes) {
	$routes->connect('/', ['controller' => 'AuthSandbox', 'action' => 'index']);

	$routes->fallbacks();
});
