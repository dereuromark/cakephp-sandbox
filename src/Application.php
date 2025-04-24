<?php

namespace App;

use App\Http\Middleware\RedirectMiddleware;
use Cache\Routing\Middleware\CacheMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Core\Exception\MissingPluginException;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Exception;
use League\Container\ReflectionContainer;
use Setup\Middleware\MaintenanceMiddleware;
use Tools\Error\Middleware\ErrorHandlerMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication {

	/**
	 * @return void
	 */
	public function bootstrap(): void {
		// Call parent to load bootstrap from files.
		parent::bootstrap();

		if (PHP_SAPI === 'cli') {
			$this->bootstrapCli();
		}

		if (Configure::read('debug')) {
			$this->addPlugin('DebugKit');
			try {
				$this->addPlugin('TestHelper');
			} catch (Exception $exception) {
				// This is OK live
			}
		}

		// Load more plugins here
	}

	/**
	 * Setup the middleware your application will use.
	 *
	 * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
	 * @return \Cake\Http\MiddlewareQueue The updated middleware.
	 */
	public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue {
		$middlewareQueue
			->add(MaintenanceMiddleware::class)

			// Catch any exceptions in the lower layers,
			// and make an error page/response
			// Removed for now because of Whoops Error Handler
			->add(new ErrorHandlerMiddleware())

			// Handle plugin/theme assets like CakePHP normally does.
			->add(AssetMiddleware::class)

			// Handle cached files
			->add(CacheMiddleware::class)

			->add(RedirectMiddleware::class)

			// Apply routing
			->add(new RoutingMiddleware($this));

		return $middlewareQueue;
	}

	/**
	 * Register application container services.
	 *
	 * @param \Cake\Core\ContainerInterface $container The Container to update.
	 * @return void
	 */
	public function services(ContainerInterface $container): void {
		$container->delegate(
			new ReflectionContainer(true),
		);
	}

	/**
	 * @return void
	 */
	protected function bootstrapCli() {
		try {
			$this->addPlugin('IdeHelper');
			$this->addPlugin('Bake');

			$this->addPlugin('ModelGraph');

		} catch (MissingPluginException $e) {
			// Do not halt if the plugin is missing
		}
	}

}
