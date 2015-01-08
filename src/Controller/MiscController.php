<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class MiscController extends AppController {

	public $uses = array(); //'Tool'

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow('index', 'convert_text', 'analyze_text');
	}

	/**
	 * Overview
	 */
	public function index() {
	}

	public $types = array(
		'1' => 'html encode',
		'2' => 'html decode',
		'3' => 'entity encode',
		'4' => 'entity decode',
		'5' => 'indent',
		'6' => 'outdent'
	);

	/**
	 * 2010-09-30 ms
	 */
	public function convert_text() {

		if ($this->Common->isPosted()) {
			$this->request->data['Form']['result'] = $this->_process($this->request->data['Form']['text'], $this->request->data['Form']['type']);
			if (array_key_exists((string)$this->request->data['Form']['type'], $this->types)) {
				$this->Flash->message($this->types[(string)$this->request->data['Form']['type']] . ' done', 'success');
			} else {
				$this->Flash->message($this->types[(string)$this->request->data['Form']['type']] . ' not successfull', 'warning');
			}
		}

		$types = $this->types;
		$this->set(compact('types'));
	}

	protected function _process($text, $type = null) {
		if (empty($type)) {
			# auto detect
			$type = $this->_autoDetect($text);
			$this->request->data['Form']['type'] = $type;
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
				$pieces = explode(NL, $text);
				foreach ($pieces as $key => $val) {
					$pieces[$key] = TB . $val;
				}
				$text = implode(NL, $pieces);
				break;
			case '6':
				$pieces = explode(NL, $text);
				foreach ($pieces as $key => $val) {
					$pieces[$key] = mb_substr($val, 0, 1) === TB ? mb_substr($val, 1) : $val;
				}
				$text = implode(NL, $pieces);
				break;
		}
		return $text;
	}

	protected function _autoDetect($text) {
		if (mb_strpos($text, '&gt;') !== false || mb_strpos($text, '&lt;') || mb_strpos($text, '&amp;') || mb_strpos($text, '&quot;')) { // || mb_strpos($text, '&#39;')
			return 2;
		}
		return 1;
	}

	public function analyze_text() {
		$results = array();

		if ($this->Common->isPosted()) {
			$results = $this->_analyze($this->request->data['Form']['text']);
		}

		$this->set(compact('results'));
	}

	protected function _analyze($text, $type = null) {
		$res = array();
		if (empty($text)) {
			return $res;
		}

		$textLib = new TextLib($text);

		ini_set('memory_limit', '128M');

		$res['words'] = $textLib->wordCount($this->request->data['Form']);
		$res['sentence_count'] = $textLib->getSentence();
		$res['paragraph_count'] = $textLib->getParagraph();
		$res['length'] = $textLib->getLength();
		$res['is_ascii'] = $textLib->isAscii();
		$res['word_count'] = $textLib->getWord();

		return $res;
	}

}

