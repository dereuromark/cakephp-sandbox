<?php

namespace App\Controller;

class MiscController extends AppController {

	/**
	 * @var array<string>
	 */
	protected $types = [
		'1' => 'html encode',
		'2' => 'html decode',
		'3' => 'entity encode',
		'4' => 'entity decode',
		'5' => 'indent',
		'6' => 'outdent',
	];

	/**
	 * Overview
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function convertText() {
		if ($this->Common->isPosted()) {
			$data = $this->request->getData();
			$data['Form']['result'] = $this->_process($data['Form']['text'], $data['Form']['type']);
			if (array_key_exists((string)$data['Form']['type'], $this->types)) {
				$this->Flash->success($this->types[(string)$data['Form']['type']] . ' done');
			} else {
				$this->Flash->warning($this->types[(string)$data['Form']['type']] . ' not successful');
			}
		}

		$types = $this->types;
		$this->set(compact('types'));
	}

	/**
	 * @param string $text
	 * @param string|int|null $type
	 *
	 * @return string
	 */
	protected function _process($text, $type = null) {
		if (!$type) {
			# auto detect
			$type = $this->_autoDetect($text);
			//$data['Form']['type'] = $type;
			//return $text;
		}

		switch ($type) {
			case '1':
				$text = h($text);

				break;
			case '2':
				$text = hDec($text);

				break;
			case '3':
				$text = ent($text);

				break;
			case '4':
				$text = entDec($text);

				break;
			case '5':
				$pieces = explode(NL, $text) ?: [];
				foreach ($pieces as $key => $val) {
					$pieces[$key] = TB . $val;
				}
				$text = implode(NL, $pieces);

				break;
			case '6':
				$pieces = explode(NL, $text) ?: [];
				foreach ($pieces as $key => $val) {
					$pieces[$key] = mb_substr($val, 0, 1) === TB ? mb_substr($val, 1) : $val;
				}
				$text = implode(NL, $pieces);

				break;
		}

		return $text;
	}

	/**
	 * @param string $text
	 *
	 * @return int
	 */
	protected function _autoDetect($text) {
		if (mb_strpos($text, '&gt;') !== false || mb_strpos($text, '&lt;') || mb_strpos($text, '&amp;') || mb_strpos($text, '&quot;')) { // || mb_strpos($text, '&#39;')
			return 2;
		}

		return 1;
	}

}
