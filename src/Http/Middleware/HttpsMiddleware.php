<?php
namespace App\Http\Middleware;

use Cake\Core\Configure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Ensures SSL (https) to be used in production.
 */
class HttpsMiddleware {

	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request The request.
	 * @param \Psr\Http\Message\ResponseInterface $response The response.
	 * @param callable $next Callback to invoke the next middleware.
	 * @return \Psr\Http\Message\ResponseInterface A response
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next) {
		if (!$this->requiresRedirect($request)) {
			return $next($request, $response);
		}

		$params = $request->getServerParams();
		$url = 'https://' . $params['HTTP_HOST'] . $params['REQUEST_URI'];
		$response = $response->withHeader('Location', $url);

		return $response;
	}

	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 *
	 * @return bool
	 */
	protected function requiresRedirect(ServerRequestInterface $request) {
		if (Configure::read('debug')) {
			return false;
		}
		$live = Configure::read('Config.live');
		if ($live === false) {
			return false;
		}

		$method = $request->getMethod();
		if ($method !== 'GET') {
			// Throw exception?
			return false;
		}

		$params = $request->getServerParams();
		if ($params['REQUEST_SCHEME'] !== 'http') {
			return false;
		}

		return true;
	}

}
