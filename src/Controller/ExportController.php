<?php
namespace Controller;
App::uses('AppController', 'Controller');

class ExportController extends AppController {

	public $uses = array();

	/**
	 * ExportController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();

		if ($this->viewClass === 'View') {
			return;
		}

		if ($this->referer(null, true) !== '/export') {
			throw new MethodNotAllowedException('Please do not use this as a webservice (the capacities are limited). Download the JSON or XML file and import it.');
		}
		//die($this->referer(null, true));
	}

	/**
	 * ExportController::afterFilter()
	 *
	 * @return void
	 */
	public function afterFilter() {
		parent::afterFilter();

		if ($this->request->query('download')) {
			$this->response->download($this->request->params['action'] . '.' . $this->request->params['ext']);
		}
	}

	public function index() {
	}

	/**
	 *
	 */
	public function countries() {
		$this->Country = ClassRegistry::init('Data.Country');
		$countries = $this->Country->find('all', array('fields' => array()));

		$this->set(compact('countries'));
		$this->set('_serialize', array('countries'));
	}

	/**
	 * maybe with countries directly?
	 */
	public function country_provinces() {
		$this->CountryProvince = ClassRegistry::init('Data.CountryProvince');
		$countryProvinces = $this->CountryProvince->find('all', array('fields' => array()));

		$this->set(compact('countryProvinces'));
		$this->set('_serialize', array('countryProvinces'));
	}

	/**
	 *
	 */
	public function currencies() {
		$this->Currency = ClassRegistry::init('Data.Currency');
		$currencies = $this->Currency->find('all', array('fields' => array()));

		$this->set(compact('currencies'));
		$this->set('_serialize', array('currencies'));
	}

	/**
	 *
	 */
	public function languages() {
		$this->Language = ClassRegistry::init('Data.Language');
		$languages = $this->Language->find('all', array('fields' => array()));

		$this->set(compact('languages'));
		$this->set('_serialize', array('languages'));
	}

	/**
	 *
	 */
	public function continents() {
		$this->Continent = ClassRegistry::init('Data.Continent');
		$continents = $this->Continent->find('all', array('fields' => array()));

		$this->set(compact('continents'));
		$this->set('_serialize', array('continents'));
	}

	/**
	 *
	 */
	public function postal_codes() {
		$this->PostalCode = ClassRegistry::init('Data.PostalCode');
		$postalCodes = $this->PostalCode->find('all', array('fields' => array()));

		$this->set(compact('postalCodes'));
		$this->set('_serialize', array('postalCodes'));
	}

	/**
	 * and mime_type_images
	 */
	public function mime_types() {
	}

}

