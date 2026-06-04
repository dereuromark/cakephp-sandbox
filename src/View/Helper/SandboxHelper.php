<?php

namespace App\View\Helper;

use Cake\Error\Debugger;
use Cake\View\Helper;

/**
 * @extends \Cake\View\Helper<\Cake\View\View>
 */
class SandboxHelper extends Helper {

	/**
	 * @param string $input the input-string
	 * @param array<string, mixed> $options
	 * @return string the manipulated string
	 */
	public function pre($input, array $options = []) {
		$options += ['escape' => true];

		$output = Debugger::exportVar($input);
		if ($options['escape'] !== false) {
			$output = h($output);
		}

		return '<pre>' . $output . '</pre>';
	}

}
