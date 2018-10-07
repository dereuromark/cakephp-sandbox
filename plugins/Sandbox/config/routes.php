<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('admin', function (RouteBuilder $routes) {
		$routes->plugin('Sandbox', function (RouteBuilder $routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
		});
});

Router::plugin('Sandbox', function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'Sandbox', 'action' => 'index'], ['routeClass' => 'DashedRoute']);

		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});
