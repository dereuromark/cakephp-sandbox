<?php

namespace Sandbox\View\Helper;

use Cake\View\Helper;
use MediaEmbed\MediaEmbed;

/**
 * @property \Cake\View\Helper\TextHelper $Text
 */
class MediaEmbedBbcodeHelper extends Helper {

	/**
	 * @var array
	 */
	public $helpers = [
		'Text',
	];

	/**
	 * @var \MediaEmbed\MediaEmbed|null
	 */
	protected $MediaEmbed;

	/**
	 * @param string $string
	 * @return string
	 */
	public function prepareForOutput($string) {
		$string = $this->Text->autoParagraph(h($string));

		return preg_replace_callback('/\[video=?(.*?)\](.*?)\[\/video\]/is', [$this, '_finalizeVideo'], $string);
	}

	/**
	 * @param array $params
	 * @return string
	 */
	protected function _finalizeVideo($params) {
		if (!isset($this->MediaEmbed)) {
			$this->MediaEmbed = new MediaEmbed();
		}
		$host = $params[1];
		$id = $params[2];
		$MediaObject = $this->MediaEmbed->parseId($id, $host);
		if (!$MediaObject) {
			return $params[0];
		}

		return $MediaObject->getEmbedCode();
	}

}
