<?php
App::uses('MyHelper', 'Tools.View/Helper');

class AppHelper extends MyHelper {

	/**
	 * Replaces the special chars back to the 'real' chars.
	 * For example &amp; => &
	 *
	 * @deprecated
	 * @param string $input the input-string
	 * @return string the manipulated string
	 */
	public function htmlspecialcharsBack($input) {
		$search = array('&amp;', '&gt;', '&lt;', '&quot;', '&#039;');
		$replace = array('&', '>', '<', '"', "'");
		return str_replace($search, $replace, $input);
	}

}
