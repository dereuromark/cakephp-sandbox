<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * CORS Middleware
 *
 * Allows cross-origin requests from trusted domains for API endpoints.
 * This enables documentation sites to use sandbox APIs for live demos.
 */
class CorsMiddleware implements MiddlewareInterface {

	/**
	 * Allowed origins for CORS requests.
	 *
	 * @var array<string>
	 */
	protected array $allowedOrigins = [
		'https://php-collective.github.io',
		'https://sandbox.dereuromark.de',
	];

	/**
	 * Process the request and add CORS headers if origin is allowed.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request The request.
	 * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
	 * @return \Psr\Http\Message\ResponseInterface A response.
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$origin = $request->getHeaderLine('Origin');

		// Handle preflight OPTIONS requests
		if ($request->getMethod() === 'OPTIONS') {
			$response = new Response();
			$response = $response->withStatus(204);
		} else {
			$response = $handler->handle($request);
		}

		// Only add CORS headers if origin is in allowlist
		if ($origin !== '' && in_array($origin, $this->allowedOrigins, true)) {
			$response = $response
				->withHeader('Access-Control-Allow-Origin', $origin)
				->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
				->withHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With')
				->withHeader('Access-Control-Max-Age', '86400');
		}

		return $response;
	}

}
