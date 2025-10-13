<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\View\JsonView;
use Cake\View\XmlView;

/**
 * @property \Cache\Controller\Component\CacheComponent $Cache
 */
class ExportController extends AppController {

	/**
	 * @return string[]
	 */
	public function viewClasses(): array {
		if (!$this->request->getParam('_ext')) {
			return [];
		}

		return [JsonView::class, XmlView::class];
	}

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Cache.Cache');
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @throws \Cake\Http\Exception\MethodNotAllowedException
	 * @return \Cake\Http\Response|null|void
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
	 * @return void
	 */
	public function afterFilter(EventInterface $event): void {
		parent::afterFilter($event);

		if ($this->request->getQuery('download')) {
			$this->response = $this->response->withDownload($this->request->getParam('action') . '.' . $this->request->getParam('_ext'));
		}
	}

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function countries() {
		$countriesTable = $this->fetchTable('Data.Countries');
		$countries = $countriesTable->find()->toArray();

		$this->set(compact('countries'));
		$serialize = 'countries';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function states() {
		$statesTable = $this->fetchTable('Data.States');
		$states = $statesTable->find()->toArray();

		$this->set(compact('states'));
		$serialize = 'states';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function currencies() {
		$currenciesTable = $this->fetchTable('Data.Currencies');
		$currencies = $currenciesTable->find()->toArray();

		$this->set(compact('currencies'));
		$serialize = 'currencies';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function languages() {
		$languagesTable = $this->fetchTable('Data.Languages');
		$languages = $languagesTable->find()->toArray();

		$this->set(compact('languages'));
		$serialize = 'languages';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function continents() {
		$continentsTable = $this->fetchTable('Data.Continents');
		$continents = $continentsTable->find()->toArray();

		$this->set(compact('continents'));
		$serialize = 'continents';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function postalCodes() {
		$postalCodesTable = $this->fetchTable('Data.PostalCodes');
		$postalCodes = $postalCodesTable->find()->toArray();

		$this->set(compact('postalCodes'));
		$serialize = 'postalCodes';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function timezones() {
		$timezonesTable = $this->fetchTable('Data.Timezones');
		$timezones = $timezonesTable->find()->toArray();

		$this->set(compact('timezones'));
		$serialize = 'timezones';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function mimeTypes() {
	}

}
