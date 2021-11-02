<?php

namespace App\Http\Middleware;

use Cake\Routing\Exception\RedirectException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Ensures any RedirectException thrown is redirected.
 */
class RedirectMiddleware implements MiddlewareInterface {

	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Server\RequestHandlerInterface $handler
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		try {
			$response = $handler->handle($request);

		} catch (RedirectException $e) {
			return new RedirectResponse(
				$e->getMessage(),
				(int)$e->getCode(),
			);
		}

		return $response;
	}

}
