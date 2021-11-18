<?php
/**
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Routing\RouteBuilder;

$routes->prefix('Admin', function (RouteBuilder $routes) {
		$routes->plugin('StateMachineSandbox', ['path' => '/state-machine-sandbox'], function (RouteBuilder $routes) {
			$routes->connect('/', ['controller' => 'StateMachineSandbox', 'action' => 'index']);

			$routes->fallbacks();
		});
});

$routes->plugin('StateMachineSandbox', ['path' => '/state-machine-sandbox'], function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'StateMachineSandbox', 'action' => 'index']);

		$routes->fallbacks();
});
