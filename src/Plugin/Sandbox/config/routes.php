<?php
namespace Sandbox\Config;

use Cake\Routing\Router;

Router::plugin('Sandbox', function ($routes) {
			$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
			$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});