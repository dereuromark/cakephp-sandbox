<?php

namespace App;

use App\Error\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\RedirectMiddleware;
use Cache\Routing\Middleware\CacheMiddleware;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Setup\Middleware\MaintenanceMiddleware;

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

		$this->addPlugin('Tools');
		$this->addPlugin('Setup');
		$this->addPlugin('Data');
		$this->addPlugin('Ajax');
		//$this->addPlugin('Meta', ['bootstrap' => false]);
		$this->addPlugin('Cache');
		$this->addPlugin('AssetCompress');
		//$this->addPlugin('SocialShare', ['bootstrap' => false]);
		$this->addPlugin('TinyAuth', ['bootstrap' => false]);
		$this->addPlugin('Calendar');
		$this->addPlugin('Search');
		$this->addPlugin('Geo');
		$this->addPlugin('DatabaseLog');
		$this->addPlugin('Queue');
		$this->addPlugin('Captcha');
		$this->addPlugin('CakeDto');
		//$this->addPlugin('Cake/Localized');
		//$this->addPlugin('Tags');
		//$this->addPlugin('Ratings');
		$this->addPlugin('Markup');
		$this->addPlugin('Feedback');
		$this->addPlugin('Icings/Menu');
		$this->addPlugin('Expose');

		// inside /plugins
		$this->addPlugin('AuthSandbox');
		$this->addPlugin('Sandbox');

		if (Configure::read('debug')) {
			$this->addPlugin('DebugKit');
			try {
				$this->addPlugin('TestHelper');
			} catch (\Exception $exception) {
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
			->add(ErrorHandlerMiddleware::class)

			// Handle plugin/theme assets like CakePHP normally does.
			->add(AssetMiddleware::class)

			// Handle cached files
			->add(new CacheMiddleware([
				'when' => function ($request, $response) {
					/** @var \Cake\Http\ServerRequest $request */
					return $request->is('get');
				},
			]))

			->add(RedirectMiddleware::class)

			// Apply routing
			->add(new RoutingMiddleware($this));

		return $middlewareQueue;
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

		$this->addPlugin('Migrations');
		// Load more plugins here
	}

}
