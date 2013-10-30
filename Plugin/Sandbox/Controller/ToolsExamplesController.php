<?php
App::uses('SandboxAppController', 'Sandbox.Controller');

class ToolsExamplesController extends SandboxAppController {

	public $helpers = array('Geshi.Geshi');

	public $components = array('Security');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	public function tree() {
		$this->Common->loadHelper(array('Tools.Tree'));
	}

	public function enum() {
	}

	public function bitmasks() {
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

	public function password() {
	}

	public function googlemap() {
	}

	public function qr() {

		if ($this->request->is('post')) {

		}
	}

	public function geocode() {
		$this->Model = ClassRegistry::init('Sandbox.ExampleRecord');
		$this->Model->Behaviors->load('Tools.Geocoder', array('before' => 'validate', 'address' => array('location')));
		if ($this->request->is('post')) {
			$this->Model->set($this->request->data);
			$this->Model->validates();

			$data = $this->Model->data;
			if (!empty($data['ExampleRecord']['geocoder_result'])) {
				$this->Common->flashMessage('Location geocoded: ' . $data['ExampleRecord']['lat'] . '/' . $data['ExampleRecord']['lng'], 'success');
			} else {
				$this->Common->flashMessage('Location could not be geocoded.', 'error');
			}
			$this->set(compact('data'));
		}
	}

	public function captcha() {
	}

	public function diff() {
	}

	public function typography() {

		$this->Common->loadHelper(array('Tools.Typography'));
	}

}

