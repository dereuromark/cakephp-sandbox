<?php
namespace App;

use App\Error\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\HttpsMiddleware;
use Cache\Routing\Middleware\CacheMiddleware;
use Cake\Http\BaseApplication;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

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
	public function bootstrap() {
		// Call parent to load bootstrap from files.
		parent::bootstrap();

		//$this->addPlugin('AssetCompress');
	}

	/**
	 * Setup the middleware your application will use.
	 *
	 * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
	 * @return \Cake\Http\MiddlewareQueue The updated middleware.
	 */
	public function middleware($middlewareQueue) {
		$middlewareQueue
			// Catch any exceptions in the lower layers,
			// and make an error page/response
			// Removed for now because of Whoops Error Handler
			->add(ErrorHandlerMiddleware::class)

			// Handle plugin/theme assets like CakePHP normally does.
			->add(AssetMiddleware::class)

			// Handle cached files
			->add(new CacheMiddleware([
				'when' => function ($request, $response) {
					return $request->is('get');
				},
			]))

			->add(HttpsMiddleware::class)

			// Apply routing
			->add(RoutingMiddleware::class);

		return $middlewareQueue;
	}

}
