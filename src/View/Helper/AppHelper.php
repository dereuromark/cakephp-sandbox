<?php
namespace App\View\Helper;

use Cake\View\Helper;

class AppHelper extends Helper {

	/**
	 * Replaces the special chars back to the 'real' chars.
	 * For example &amp; => &
	 *
	 * @deprecated
	 * @param string $input the input-string
	 * @return string the manipulated string
	 */
	public function htmlspecialcharsBack($input) {
		$search = ['&amp;', '&gt;', '&lt;', '&quot;', '&#039;'];
		$replace = ['&', '>', '<', '"', "'"];
		return str_replace($search, $replace, $input);
	}

}
