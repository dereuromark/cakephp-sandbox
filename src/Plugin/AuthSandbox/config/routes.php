<?php
namespace AuthSandbox\Config;

use Cake\Routing\Router;

// With Router::defaultRouteClass('InflectedRoute'); in the app's routes config
// This always results in the URL /auth_sandbox/auth-sandbox instead of /auth-sandbox/auth-sandbox ...

Router::prefix('admin', function ($routes) {
	$routes->plugin('AuthSandbox', ['path' => '/auth-sandbox'], function ($routes) {
		$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
		$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
	});
});

Router::plugin('AuthSandbox', ['path' => '/auth-sandbox'], function ($routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});
