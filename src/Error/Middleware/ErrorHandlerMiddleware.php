<?php

namespace App\Error\Middleware;

use Cake\Error\Middleware\ErrorHandlerMiddleware as CoreErrorHandlerMiddleware;
use Cake\Log\Log;
use Tools\Error\ErrorHandlerTrait;

/**
 * Error handling middleware.
 *
 * Uses Whoops
 */
class ErrorHandlerMiddleware extends CoreErrorHandlerMiddleware {

	use ErrorHandlerTrait;

	/**
	 * Log an error for the exception if applicable.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request The current request.
	 * @param \Exception $exception The exception to log a message for.
	 *
	 * @return void
	 */
	protected function logException($request, $exception) {
		if ($this->is404($exception, $request)) {
			$level = LOG_ERR;
			Log::write($level, $this->getMessage($request, $exception), ['404']);

			return;
		}

		parent::logException($request, $exception);
	}

}
