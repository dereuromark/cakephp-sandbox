<?php

namespace App\Error;

use Cake\Error\ErrorHandler as CoreErrorHandler;
use Cake\Log\Log;
use Exception;
use Tools\Error\ErrorHandlerTrait;

/**
 * Custom ErrorHandler to not mix the 404 exceptions with the rest of "real" errors in the error.log file.
 *
 * Also uses Whoops error handling.
 */
class ErrorHandler extends CoreErrorHandler {

	use ErrorHandlerTrait;

	/**
	 * Handles exception logging
	 *
	 * @param \Exception $exception Exception instance.
	 *
	 * @return bool
	 */
	protected function _logException(Exception $exception) {
		if ($this->is404($exception)) {
			$level = LOG_ERR;
			Log::write($level, $this->_getMessage($exception), ['404']);
			return false;
		}
		return parent::_logException($exception);
	}

}
