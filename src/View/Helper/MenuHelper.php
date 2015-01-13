<?php
namespace App\View\Helper;

// http://cakeforge.org/snippet/detail.php?type=snippet&id=194

class MenuHelper extends Helper {

	public $helpers = array('Html');

	protected $_out;

	protected $_typeTags = array('dl' => 'dd', 'ul' => 'li', 'ol' => 'li');

	/**
	 *
	 * @param array 	$data data for menu as Name=>value pairs
	 * @param string 	$tag html tag to enclose link in
	 * @param string 	$activeClass Css class to use for highlight
	 * usage: <?php $this->Menus->menu(array('Home'=>'/home', 'Profile'=>'/profile'), 'li', 'current'); ?>
	 */

	public function menu($data = array(), $tag = 'li', $activeClass = 'current', $mainMenuActive = null) {
		// reset output
		$this->_out = array();
		// check data
		if (empty($data) && count($data) < 1) {
			return '';
		}

		// sort out matching links
		$matchingLinks = array();

		foreach ($data as $link) {
			//
			if ($mainMenuActive) {
				if (preg_match('/^' . preg_quote($link, '/') . '/', $mainMenuActive)) {
					$matchingLinks[strlen($link)] = $link;
				}
			} else {
				if (preg_match('/^' . preg_quote($link, '/') . '/', substr($this->request->here, strlen($this->request->base)))) {
					$matchingLinks[strlen($link)] = $link;
				}
			}
		}

		krsort($matchingLinks);

		$activeLink = !empty($matchingLinks) ? array_shift($matchingLinks) : null;

		# VIEW html

		foreach ($data as $title => $link) {
			$content = $this->Html->link($title, $link, $link == $activeLink ? array('class' => $activeClass) : false);
			$this->_out[] = '<' . $tag . '>' . $content . '</' . $tag . '>';
		}

		return implode("", $this->_out);
	}

	/**
	 *
	 * @param array 	$data data for menu as Name=>array(Name=>value) pairs
	 * @param array 	$options options for menu as array to enable new features to be added
	 * usage: <?php $this->Menu->twoTierMenu($data, array('type'=>'dl', 'class'=>'sub-menu', 'title'=>'dt', 'activeClass'=>'current')); ?>
	 */

	public function twoTierMenu($data = array(), $options = array('activeClass' => 'current', 'type' => 'ul', 'class' => false, 'title' => false)) {
		// reset output
		$this->_out = array();
		// check data
		if (empty($data) && count($data) < 1) {
			return '';
		}
		// check we have a 2 level structure
		$keys = array_keys($data);
		if (!is_array($data[$keys[0]])) {
			return '';
		}

		// sort out matching links
		$activeLinks = array();

		// get array of all links
		foreach ($data as $groupTitle => $groupLinks) {
			$matchingLinks = array();

			foreach ($groupLinks as $linkTitle => $linkUrl) {
				if (preg_match('/^' . preg_quote($linkUrl, '/') . '/', substr($this->request->here, strlen($this->request->base)))) {
					// if (preg_match('/^'.preg_quote($link, '/').'/', $this->request->url)) {
					$matchingLinks[strlen($linkUrl)] = $linkUrl;
				} elseif ($linkUrl == substr($this->request->here, strlen($this->request->base))) {
					// $matchingLinks[$groupTitle][strlen($linkUrl)] = $linkUrl;
} else {
	// pr('link: '.$link.' | url: '.substr($this->request->here, strlen($this->request->base)));
}
				// pr('preg: '.preg_quote($link).'/');
				// pr('base: '.substr($this->request->here, strlen($this->request->base)));
				// pr('url: '.$this->request->url);
}
			// sorting
			krsort($matchingLinks);
			// pr($matchingLinks);
			// active link
			$activeLinks[$groupTitle] = !empty($matchingLinks) ? array_shift($matchingLinks) : null;
		}

		// pr($matchingLinks);
		// pr($activeLinks);

		// output menu
		if ($options['class']) {
			$this->_out[] = '<' . $options['type'] . ' class="' . $options['class'] . '">';
		} else {
			$this->_out[] = '<' . $options['type'] . '>';
		}

		// build html
		foreach ($data as $groupTitle => $links) {
			if ($options['title']) {
				$this->_out[] = "<" . $options['title'] . ">" . $groupTitle . "</" . $options['title'] . ">";
			}

			foreach ($links as $linkTitle => $linkUrl) {
				$this->_out[] = '<' . $this->_typeTags[$options['type']] . '>' . $this->Html->link($linkTitle, $linkUrl, $linkUrl == $activeLinks[$groupTitle] ? array('class' => $options['activeClass']) : false) . '</' . $this->_typeTags[$options['type']] . '>';
			}
		}
		$this->_out[] = '</' . $options['type'] . '>';

		// return
		return implode("\n", $this->_out);
	}

}
