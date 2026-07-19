<?php

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * @extends \Cake\View\Helper<\Cake\View\View>
 * @property \App\View\Helper\HtmlHelper $Html
 */
class NavigationHelper extends Helper {

	/**
	 * @var array<int|string, array<string, mixed>|string>
	 */
	protected array $helpers = ['Html'];

	/**
	 * @param string $link
	 * @param array<mixed> $url
	 * @param array<string, mixed> $options
	 * @return string
	 */
	public function link($link, $url, array $options = []) {
		if ($url['action'] === $this->getView()->getRequest()->getParam('action')) {
			$options['class'] = !empty($options['class']) ? ($options['class'] . ' active') : 'active';
		}

		return $this->Html->link($link, $url, $options);
	}

}
