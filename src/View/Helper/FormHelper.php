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
	 * @param array<mixed>|string|null $url
	 * @param array<string, mixed> $options
	 *
	 * @return string
	 */
	public function postLink(string $title, array|string|null $url = null, array $options = []): string {
		if (isset($options['confirm'])) {
			$options['data-confirm'] = h($options['confirm']);
		}

		return parent::postLink($title, $url, $options);
	}

}
