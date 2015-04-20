<?php
namespace Sandbox\Config;

use Cake\Routing\Router;

Router::prefix('admin', function ($routes) {
		$routes->plugin('Sandbox', function ($routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
		});
});

Router::plugin('Sandbox', function ($routes) {
		$routes->connect('/', ['controller' => 'Sandbox', 'action' => 'index'], ['routeClass' => 'DashedRoute']);

		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});
