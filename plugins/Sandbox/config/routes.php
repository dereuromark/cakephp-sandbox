<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('Admin', function (RouteBuilder $routes) {
		$routes->plugin('Sandbox', function (RouteBuilder $routes) {
			$routes->connect('/', ['controller' => 'Sandbox', 'action' => 'index']);

			$routes->fallbacks();
		});
});

Router::plugin('Sandbox', function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'Sandbox', 'action' => 'index']);

		$routes->fallbacks();
});
