<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('Admin', function (RouteBuilder $routes) {
		$routes->plugin('StateMachineSandbox', ['path' => '/state-machine-sandbox'], function (RouteBuilder $routes) {
			$routes->connect('/', ['controller' => 'StateMachineSandbox', 'action' => 'index']);

			$routes->fallbacks();
		});
});

Router::plugin('StateMachineSandbox', ['path' => '/state-machine-sandbox'], function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'StateMachineSandbox', 'action' => 'index']);

		$routes->fallbacks();
});
