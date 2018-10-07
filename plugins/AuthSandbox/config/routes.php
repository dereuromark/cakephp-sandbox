<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('admin', function (RouteBuilder $routes) {
		$routes->plugin('AuthSandbox', ['path' => '/auth-sandbox'], function (RouteBuilder $routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
		});
});

Router::plugin('AuthSandbox', ['path' => '/auth-sandbox'], function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'AuthSandbox', 'action' => 'index'], ['routeClass' => 'DashedRoute']);

		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});
