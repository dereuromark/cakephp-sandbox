<?php
use Sandbox\Controller\SandboxAppController;

class ToolsExamplesController extends SandboxAppController {

	public $helpers = array('Geshi.Geshi');

	public $components = array('Security');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	/**
	 * ToolsExamplesController::index()
	 *
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * ToolsExamplesController::tree()
	 * //TODO
	 *
	 * @return void
	 */
	public function tree() {
		$this->Common->loadHelper(array('Tools.Tree'));
	}

	/**
	 * ToolsExamplesController::bitmasks()
	 * //TODO
	 *
	 * @return void
	 */
	public function _bitmasks() {
		$flags = array(
			'1' => 'Apple',
			'2' => 'Peach',
			'4' => 'Banana',
			'8' => 'Lemon',
			'16' => 'Coconut',
		);
		$this->Model = ClassRegistry::init('Sandbox.BitmaskRecord');
		$this->Model->Behaviors->load('Tools.Bitmasked', array('field' => 'flag', 'bits' => $flags));

		$records = $this->Model->find('all');

		if ($this->request->is('post')) {

		}

		$this->set(compact('records', 'flags'));
	}

	/**
	 * //TODO
	 *
	 * @return void
	 */
	public function _password() {
	}

	/**
	 * Display a Google map.
	 *
	 * @return void
	 */
	public function googlemap() {
		$this->helpers[] = 'Tools.GoogleMapV3';
	}

	/**
	 * ToolsExamplesController::qr()
	 *
	 * @return void
	 */
	public function qr() {
		$types = array('text' => 'Text', 'url' => 'Url', 'tel' => 'Phone Number', 'sms' => 'Text message', 'email' => 'E-Mail', 'geo' => 'Geo', 'market' => 'Market', 'card' => 'Vcard');

		if ($this->Common->isPosted()) {
			switch ($this->request->data['Misc']['type']) {
				case 'url':
				case 'tel':
				case 'email':
				case 'geo':
				case 'market':
					$result = str_replace(array(PHP_EOL, NL), ' ', $this->request->data['Misc']['content']);
					break;
				case 'card':
					$result = $this->request->data['Card'];
					$result['birthday'] = $result['birthday']['year'] . '-' . $result['birthday']['month'] . '-' . $result['birthday']['day'];

					break;
				case 'sms':
					$result = array($this->request->data['Sms']['number'], $this->request->data['Sms']['content']);
					break;
				case 'text':
					$result = $this->request->data['Misc']['content'];
					break;
				default:
					$result = null;
			}
			$this->set(compact('result'));
		}

		$this->set(compact('types'));
		$this->helpers[] = 'Tools.QrCode';
	}

	/**
	 * ToolsExamplesController::geocode()
	 *
	 * @return void
	 */
	public function geocode() {
		$this->Model = ClassRegistry::init('Sandbox.ExampleRecord');
		$this->Model->Behaviors->load('Tools.Geocoder', array('before' => 'validate', 'address' => array('location')));
		if ($this->request->is('post')) {
			$this->Model->set($this->request->data);
			$this->Model->validates();

			$data = $this->Model->data;
			if (!empty($data['ExampleRecord']['geocoder_result'])) {
				$this->Flash->message('Location geocoded: ' . $data['ExampleRecord']['lat'] . '/' . $data['ExampleRecord']['lng'], 'success');
			} else {
				$this->Flash->message('Location could not be geocoded.', 'error');
			}
			$this->set(compact('data'));
		}
	}

	/**
	 * //TODO
	 *
	 * @return void
	 */
	public function _captcha() {
	}

	/**
	 * //TODO
	 *
	 * @return void
	 */
	public function _diff() {
	}

	public function typography() {

		$this->Common->loadHelper(array('Tools.Typography'));
	}

}

