<?php

namespace Sandbox\Controller;

use QrCode\Utility\Formatter;

class QrCodeExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$result = null;
		$options = [];
		if ($this->request->is('post')) {
			$result = $this->request->getData('content');
		}

		$this->set(compact('result', 'options'));
	}

	/**
	 * @return void
	 */
	public function svg() {
		$formatter = new Formatter();
		$types = $formatter->types();

		$result = null;
		$options = [];

		if ($this->request->is('post')) {
			switch ($this->request->getData('type')) {
				case 'text':
				case 'url':
				case 'tel':
				case 'email':
				case 'market':
					$result = $formatter->formatText($this->request->getData('content'), $this->request->getData('type'));

					break;
				case 'card':
					$result = $this->request->getData('Card');
					$result = $formatter->formatCard($result);

					break;
				case 'sms':
					$result = $formatter->formatSms($this->request->getData('Sms.number'), $this->request->getData('Sms.content'));

					break;
				case 'wifi':
					$result = $formatter->formatWifi($this->request->getData('Wifi.network'), $this->request->getData('Wifi.key'), $this->request->getData('Wifi.type'));

					break;
				case 'geo':
					$result = 'geo:' . str_replace(' ', '', $this->request->getData('content'));

					break;
			}
		}

		$ext = $this->request->getParam('action') === 'png' ? 'png' : 'svg';
		$this->set(compact('ext', 'types', 'result', 'options'));
		$this->render('complex');
	}

	/**
	 * @return void
	 */
	public function png() {
		$this->svg();

		$this->render('complex');
	}

}
