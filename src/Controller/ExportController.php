<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

class ExportController extends AppController {

	public $uses = [];

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
		$countries = $this->Countries->find('all', ['fields' => []]);

		if (!$this->viewClass) {
			throw new NotFoundException();
		}

		$this->set(compact('countries'));
		$this->set('_serialize', ['countries']);
	}

	/**
	 * maybe with countries directly?
	 */
	public function country_provinces() {
		$this->CountryProvince = TableRegistry::get('Data.CountryProvinces');
		$countryProvinces = $this->CountryProvince->find('all', ['fields' => []]);

		$this->set(compact('countryProvinces'));
		$this->set('_serialize', ['countryProvinces']);
	}

	/**
	 *
	 */
	public function currencies() {
		$this->Currency = TableRegistry::get('Data.Currencies');
		$currencies = $this->Currency->find('all', ['fields' => []]);

		$this->set(compact('currencies'));
		$this->set('_serialize', ['currencies']);
	}

	/**
	 *
	 */
	public function languages() {
		$this->Language = TableRegistry::get('Data.Languages');
		$languages = $this->Language->find('all', ['fields' => []]);

		$this->set(compact('languages'));
		$this->set('_serialize', ['languages']);
	}

	/**
	 *
	 */
	public function continents() {
		$this->Continent = TableRegistry::get('Data.Continents');
		$continents = $this->Continent->find('all', ['fields' => []]);

		$this->set(compact('continents'));
		$this->set('_serialize', ['continents']);
	}

	/**
	 *
	 */
	public function postal_codes() {
		$this->PostalCode = TableRegistry::get('Data.PostalCodes');
		$postalCodes = $this->PostalCode->find('all', ['fields' => []]);

		$this->set(compact('postalCodes'));
		$this->set('_serialize', ['postalCodes']);
	}

	/**
	 * and mime_type_images
	 */
	public function mime_types() {
	}

}
