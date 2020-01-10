<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\MethodNotAllowedException;

/**
 * @property \Cache\Controller\Component\CacheComponent $Cache
 * @property \Data\Model\Table\CountriesTable $Countries
 * @property \Data\Model\Table\StatesTable $States
 * @property \Data\Model\Table\CurrenciesTable $Currencies
 * @property \Data\Model\Table\LanguagesTable $Languages
 * @property \Data\Model\Table\ContinentsTable $Continents
 * @property \Data\Model\Table\PostalCodesTable $PostalCodes
 */
class ExportController extends AppController {

	/**
	 * @var array
	 */
	public $components = ['Cache.Cache'];

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Http\Exception\MethodNotAllowedException
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		if (!$this->viewBuilder()->getClassName() || $this->viewBuilder()->getClassName() === 'View') {
			return null;
		}

		if ($this->referer(null, true) !== '/export') {
			throw new MethodNotAllowedException('Please do not use this as a webservice (the capacities are limited). Download the JSON or XML file and import it.');
		}
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return \Cake\Http\Response|null
	 */
	public function afterFilter(EventInterface $event) {
		parent::afterFilter($event);

		if ($this->request->getQuery('download')) {
			$this->response->download($this->request->getParam('action') . '.' . $this->request->getParam('_ext'));
		}
	}

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function countries() {
		$this->loadModel('Data.Countries');
		$countries = $this->Countries->find('all', ['fields' => []]);

		$this->set(compact('countries'));
		$this->set('_serialize', ['countries']);
	}

	/**
	 * maybe with countries directly?
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function states() {
		$this->loadModel('Data.States');
		$states = $this->States->find('all', ['fields' => []]);

		$this->set(compact('states'));
		$this->set('_serialize', ['states']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function currencies() {
		$this->loadModel('Data.Currencies');
		$currencies = $this->Currencies->find('all', ['fields' => []]);

		$this->set(compact('currencies'));
		$this->set('_serialize', ['currencies']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function languages() {
		$this->loadModel('Data.Languages');
		$languages = $this->Languages->find('all', ['fields' => []]);

		$this->set(compact('languages'));
		$this->set('_serialize', ['languages']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function continents() {
		$this->loadModel('Data.Continents');
		$continents = $this->Continents->find('all', ['fields' => []]);

		$this->set(compact('continents'));
		$this->set('_serialize', ['continents']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function postalCodes() {
		$this->loadModel('Data.PostalCodes');
		$postalCodes = $this->PostalCodes->find('all', ['fields' => []]);

		$this->set(compact('postalCodes'));
		$this->set('_serialize', ['postalCodes']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function mimeTypes() {
	}

}
