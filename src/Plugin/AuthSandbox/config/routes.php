<?php
namespace AuthSandbox\Config;

use Cake\Routing\Router;

Router::prefix('admin', function ($routes) {
	// Because you are in the admin scope,
	// you do not need to include the /admin prefix
	// or the admin route element.
	$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
	$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);

	$routes->plugin('AuthSandbox', function ($routes) {
		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
	});

	$routes->plugin('Sandbox', function ($routes) {
		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
	});
});

Router::plugin('AuthSandbox', function ($routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});
