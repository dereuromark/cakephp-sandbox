<?php
/**
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;

$routes->prefix('Admin', function (RouteBuilder $routes) {
	$routes->plugin('Sandbox', function (RouteBuilder $routes) {
		$routes->connect('/', ['controller' => 'Sandbox', 'action' => 'index']);

		$routes->fallbacks();
	});
});

$routes->plugin('Sandbox', function (RouteBuilder $routes) {
	$routes->registerMiddleware('sandboxResumableCsrf', new CsrfProtectionMiddleware());
	$routes->registerMiddleware('sandboxResumableJson', new BodyParserMiddleware());
	$routes->scope('/file-storage-examples', function (RouteBuilder $routes) {
		$routes->applyMiddleware('sandboxResumableJson', 'sandboxResumableCsrf');
		$routes->connect('/resumable-upload', ['controller' => 'FileStorageExamples', 'action' => 'resumableUpload']);
		$routes->connect('/resumable-upload-consume', ['controller' => 'FileStorageExamples', 'action' => 'resumableUploadConsume']);
	});
	$routes->connect('/', ['controller' => 'Sandbox', 'action' => 'index']);

	$routes->fallbacks();
});
