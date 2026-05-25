<?php
declare(strict_types=1);

use Cake\Routing\RouteBuilder;

/**
 * @var \Cake\Routing\RouteBuilder $routes
 */
$routes->plugin(
	'MenuSandbox',
	['path' => '/menu-sandbox'],
	function (RouteBuilder $builder): void {
		$builder->connect('/', ['controller' => 'MenuSandbox', 'action' => 'index']);
		$builder->connect('/resolvers', ['controller' => 'MenuSandbox', 'action' => 'resolvers']);
		$builder->connect('/renderers', ['controller' => 'MenuSandbox', 'action' => 'renderers']);
		$builder->connect('/advanced', ['controller' => 'MenuSandbox', 'action' => 'advanced']);

		$builder->fallbacks();
	},
);
