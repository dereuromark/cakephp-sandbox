<?php
declare(strict_types=1);

use Cake\Routing\RouteBuilder;

/**
 * @var \Cake\Routing\RouteBuilder $routes
 */
$routes->plugin(
	'WorkflowSandbox',
	['path' => '/workflow-sandbox'],
	function (RouteBuilder $builder): void {
		$builder->connect('/', ['controller' => 'WorkflowSandbox', 'action' => 'index']);

		// Demo workflows
		$builder->connect('/registrations', ['controller' => 'Registrations', 'action' => 'index']);
		$builder->connect('/orders', ['controller' => 'Orders', 'action' => 'index']);
		$builder->connect('/contents', ['controller' => 'Contents', 'action' => 'index']);
		$builder->connect('/tickets', ['controller' => 'Tickets', 'action' => 'index']);
		$builder->connect('/documents', ['controller' => 'Documents', 'action' => 'index']);

		// Interactive builder
		$builder->connect('/builder', ['controller' => 'Builder', 'action' => 'index']);

		$builder->fallbacks();
	},
);
