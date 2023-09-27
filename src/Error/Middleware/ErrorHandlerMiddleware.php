<?php

namespace App\Error\Middleware;

use Cake\Error\ExceptionTrap;
use Cake\Error\Middleware\ErrorHandlerMiddleware as CoreErrorHandlerMiddleware;
use Cake\Log\Log;
use Cake\Routing\RoutingApplicationInterface;
use Tools\Error\ErrorHandlerTrait;

/**
 * Error handling middleware.
 *
 * Uses Whoops
 */
class ErrorHandlerMiddleware extends CoreErrorHandlerMiddleware {

	use ErrorHandlerTrait;

	/**
	 * Constructor
	 *
	 * @param \Cake\Error\ExceptionTrap|array $config The error handler instance
	 *  or config array.
	 * @param \Cake\Routing\RoutingApplicationInterface|null $app Application instance.
	 */
	public function __construct(ExceptionTrap|array $config = [], ?RoutingApplicationInterface $app = null)
	{
		debug($app);
		dd($config);

		parent::__construct($config, $app);
	}

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
