<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class ExportController extends AppController {

	public $uses = array();

	/**
	 * ExportController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();

		if (!$this->viewClass || $this->viewClass === 'View') {
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
	public function afterFilter(Event $event) {
		parent::afterFilter($event);

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
		$this->Countries = TableRegistry::get('Data.Countries');
		$countries = $this->Countries->find('all', array('fields' => array()));

		$this->set(compact('countries'));
		$this->set('_serialize', array('countries'));
	}

	/**
	 * maybe with countries directly?
	 */
	public function country_provinces() {
		$this->CountryProvince = TableRegistry::get('Data.CountryProvinces');
		$countryProvinces = $this->CountryProvince->find('all', array('fields' => array()));

		$this->set(compact('countryProvinces'));
		$this->set('_serialize', array('countryProvinces'));
	}

	/**
	 *
	 */
	public function currencies() {
		$this->Currency = TableRegistry::get('Data.Currencies');
		$currencies = $this->Currency->find('all', array('fields' => array()));

		$this->set(compact('currencies'));
		$this->set('_serialize', array('currencies'));
	}

	/**
	 *
	 */
	public function languages() {
		$this->Language = TableRegistry::get('Data.Languages');
		$languages = $this->Language->find('all', array('fields' => array()));

		$this->set(compact('languages'));
		$this->set('_serialize', array('languages'));
	}

	/**
	 *
	 */
	public function continents() {
		$this->Continent = TableRegistry::get('Data.Continents');
		$continents = $this->Continent->find('all', array('fields' => array()));

		$this->set(compact('continents'));
		$this->set('_serialize', array('continents'));
	}

	/**
	 *
	 */
	public function postal_codes() {
		$this->PostalCode = TableRegistry::get('Data.PostalCodes');
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
