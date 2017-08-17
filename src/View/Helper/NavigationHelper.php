<?php
namespace App\View\Helper;

use Cake\View\Helper;

/**
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class NavigationHelper extends Helper {

	/**
	 * @var array
	 */
	public $helpers = ['Html'];

	/**
	 * @param string $link
	 * @param array $url
	 * @param array $options
	 * @return string
	 */
	public function link($link, $url, array $options = []) {
		if ($url['action'] === $this->request->param('action')) {
			$options['class'] = !empty($options['class']) ? ($options['class'] . ' active') : 'active';
		}

		return $this->Html->link($link, $url, $options);
	}

}
