<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware to return 404 for requests that match a route but the controller doesn't exist.
 *
 * This prevents auth middleware from logging ForbiddenExceptions for non-existent
 * controllers (e.g., bots requesting /sitemap.xml, /wp-admin.php, etc.)
 */
class MissingControllerMiddleware implements MiddlewareInterface {

	/**
	 * Static file extensions that should return 404 silently (not logged).
	 * These are typically browser/dev-tool requests, not bot probing.
	 *
	 * @var array<string>
	 */
	protected const SILENT_EXTENSIONS = ['map'];

	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Server\RequestHandlerInterface $handler
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$params = $request->getAttribute('params');
		if (!$params || empty($params['controller'])) {
			return $handler->handle($request);
		}

		$controller = $params['controller'];
		$plugin = $params['plugin'] ?? null;
		$prefix = $params['prefix'] ?? null;

		$className = $this->getControllerClassName($controller, $plugin, $prefix);
		if ($className === null || !class_exists($className)) {
			// For static file extensions, return 404 silently without logging
			$path = $request->getUri()->getPath();
			$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
			if (in_array($extension, static::SILENT_EXTENSIONS, true)) {
				return (new Response())->withStatus(404);
			}

			throw new NotFoundException('Controller not found: ' . $controller);
		}

		return $handler->handle($request);
	}

	/**
	 * Build controller class name from route params.
	 *
	 * @param string $controller
	 * @param string|null $plugin
	 * @param string|null $prefix
	 * @return string|null
	 */
	protected function getControllerClassName(string $controller, ?string $plugin, ?string $prefix): ?string {
		$namespace = 'App';
		if ($plugin) {
			$namespace = str_replace('/', '\\', $plugin);
		}

		$prefixPart = '';
		if ($prefix) {
			$prefixPart = str_replace('/', '\\', $prefix) . '\\';
		}

		return $namespace . '\\Controller\\' . $prefixPart . $controller . 'Controller';
	}

}
