<?php

namespace Sandbox\View\Helper;

use Cake\View\Helper;
use MediaEmbed\MediaEmbed;

/**
 * @extends \Cake\View\Helper<\Cake\View\View>
 * @property \Cake\View\Helper\TextHelper $Text
 */
class MediaEmbedBbcodeHelper extends Helper {

	/**
	 * @var array<int|string, array<string, mixed>|string>
	 */
	protected array $helpers = [
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
	public function prepareForOutput($string): string {
		$string = $this->Text->autoParagraph(h($string));

		return (string)preg_replace_callback('/\[video=?(.*?)\](.*?)\[\/video\]/is', [$this, '_finalizeVideo'], $string);
	}

	/**
	 * @param array<string> $params
	 * @return string
	 */
	protected function _finalizeVideo(array $params) {
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
