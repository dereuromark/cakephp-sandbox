<?php

namespace App;

use App\Http\Middleware\RedirectMiddleware;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\MapResolver;
use Cake\Http\ServerRequest;
use TinyAuth\Policy\RequestPolicy;
use Cache\Routing\Middleware\CacheMiddleware;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Core\Exception\MissingPluginException;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router;
use Exception;
use League\Container\ReflectionContainer;
use Psr\Http\Message\ServerRequestInterface;
use Setup\Middleware\MaintenanceMiddleware;
use TinyAuth\Middleware\RequestAuthorizationMiddleware;
use Tools\Error\Middleware\ErrorHandlerMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface {

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
			->add(new RoutingMiddleware($this))

			// Authentication middleware
			->add(new AuthenticationMiddleware($this))

			// Authorization middleware
			->add(new AuthorizationMiddleware($this))

			// TinyAuth Request Authorization middleware for INI-based RBAC
			->add(new RequestAuthorizationMiddleware([
				'unauthorizedHandler' => [
					'className' => 'TinyAuth.ForbiddenCakeRedirect',
					'url' => [
						'prefix' => false,
						'plugin' => false,
						'controller' => 'Account',
						'action' => 'login',
					],
					'unauthorizedMessage' => 'You are not authorized to access that location.',
				],
			]));

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

	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @return \Authentication\AuthenticationServiceInterface
	 */
	public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface {
		$service = new AuthenticationService();

		$loginUrl = [
			'prefix' => false,
			'plugin' => false,
			'controller' => 'Account',
			'action' => 'login',
		];

		// Define where users should be redirected to when they are not authenticated
		$service->setConfig([
			'unauthenticatedRedirect' => Router::url($loginUrl),
			'queryParam' => 'redirect',
		]);

		// Form field mapping (HTML form uses 'login' field)
		$formFields = [
			AbstractIdentifier::CREDENTIAL_USERNAME => 'login',
			AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
		];

		// Password identifier configuration for multi-column authentication
		// The username can match EITHER 'username' OR 'email' columns
		$passwordIdentifier = [
			'Authentication.Password' => [
				'fields' => [
					AbstractIdentifier::CREDENTIAL_USERNAME => ['username', 'email'],
					AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
				],
				'resolver' => [
					'className' => 'Authentication.Orm',
					'userModel' => 'Users',
				],
			],
		];

		// Load the authenticators. Session should be first.
		$service->loadAuthenticator('Authentication.Session');

		// Form authenticator for login
		// Note: No loginUrl restriction to allow multiple login pages (Account and AuthSandbox)
		$service->loadAuthenticator('Authentication.Form', [
			'identifier' => $passwordIdentifier,
			'fields' => $formFields,
		]);

		return $service;
	}

	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @return \Authorization\AuthorizationServiceInterface
	 */
	public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface {
		$mapResolver = new MapResolver();
		$mapResolver->map(ServerRequest::class, new RequestPolicy());

		return new AuthorizationService($mapResolver);
	}

}
