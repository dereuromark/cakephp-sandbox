<?php

namespace App\View\Helper;

use BootstrapUI\View\Helper\FormHelper as BootstrapFormHelper;

/**
 * @property \Cake\View\Helper\UrlHelper $Url
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class FormHelper extends BootstrapFormHelper {

	/**
	 * @param string $title
	 * @param string|array|null $url
	 * @param array $options
	 *
	 * @return string
	 */
	public function postLink($title, $url = null, array $options = []) {
		if (isset($options['confirm'])) {
			$options['data-confirm'] = h($options['confirm']);
		}

		return parent::postLink($title, $url, $options);
	}

}
