<?php
App::uses('SandboxAppController', 'Sandbox.Controller');

class AjaxExamplesController extends SandboxAppController {

	public $components = array('Data.CountryProvinceHelper');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * Main AJAX example.
	 *
	 * @return void
	 */
	public function chained_dropdowns() {
		if ($this->request->is('post')) {
			$this->User = ClassRegistry::init('User');
			$this->User->validate['country_province_id']['numeric'] = array(
				'rule' => 'numeric',
				'message' => 'Please select something'
			);
			$this->User->set($this->request->data);
			$result = $this->User->validates();
		}

		$this->CountryProvinceHelper->provideData(false, 'User');
	}

	/**
	 * My own convention was to suffix AJAX only actions with "_ajax".
	 *
	 * @return void
	 */
	public function country_provinces_ajax() {
		//$this->request->onlyAllow('ajax');
		$id = $this->request->query('id');
		if (!$id) {
			throw new NotFoundException();
		}

		$this->viewClass = 'Tools.Ajax';

		$this->loadModel('Data.CountryProvince');
		$countryProvinces = $this->CountryProvince->getListByCountry($id);

		$this->set(compact('countryProvinces'));
	}

}

