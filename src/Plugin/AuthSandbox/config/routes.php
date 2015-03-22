<?php
namespace AuthSandbox\Config;

use Cake\Routing\Router;

Router::prefix('admin', function ($routes) {
	$routes->plugin('AuthSandbox', function ($routes) {
		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
	});
});

Router::plugin('AuthSandbox', function ($routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});
