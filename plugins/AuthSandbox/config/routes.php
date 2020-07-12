<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('Admin', function (RouteBuilder $routes) {
		$routes->plugin('AuthSandbox', ['path' => '/auth-sandbox'], function (RouteBuilder $routes) {
			$routes->connect('/', ['controller' => 'AuthSandbox', 'action' => 'index']);

			$routes->fallbacks();
		});
});

Router::plugin('AuthSandbox', ['path' => '/auth-sandbox'], function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'AuthSandbox', 'action' => 'index']);

		$routes->fallbacks();
});
