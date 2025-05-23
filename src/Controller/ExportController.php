<?php

namespace App\Controller;

use Cake\Datasource\ModelAwareTrait;
use Cake\Event\EventInterface;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\View\JsonView;
use Cake\View\XmlView;
use Shim\Datasource\LegacyModelAwareTrait;

/**
 * @property \Cache\Controller\Component\CacheComponent $Cache
 * @property \Data\Model\Table\CountriesTable $Countries
 * @property \Data\Model\Table\StatesTable $States
 * @property \Data\Model\Table\CurrenciesTable $Currencies
 * @property \Data\Model\Table\LanguagesTable $Languages
 * @property \Data\Model\Table\ContinentsTable $Continents
 * @property \Data\Model\Table\PostalCodesTable $PostalCodes
 * @property \Data\Model\Table\TimezonesTable $Timezones
 */
#[\AllowDynamicProperties]
class ExportController extends AppController {

	use ModelAwareTrait;
	use LegacyModelAwareTrait;

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
		$this->loadModel('Data.Countries');
		$countries = $this->Countries->find('all')->toArray();

		$this->set(compact('countries'));
		$serialize = 'countries';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function states() {
		$this->loadModel('Data.States');
		$states = $this->States->find('all')->toArray();

		$this->set(compact('states'));
		$serialize = 'states';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function currencies() {
		$this->loadModel('Data.Currencies');
		$currencies = $this->Currencies->find('all')->toArray();

		$this->set(compact('currencies'));
		$serialize = 'currencies';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function languages() {
		$this->loadModel('Data.Languages');
		$languages = $this->Languages->find('all')->toArray();

		$this->set(compact('languages'));
		$serialize = 'languages';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function continents() {
		$this->loadModel('Data.Continents');
		$continents = $this->Continents->find('all')->toArray();

		$this->set(compact('continents'));
		$serialize = 'continents';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function postalCodes() {
		$this->loadModel('Data.PostalCodes');
		$postalCodes = $this->PostalCodes->find('all')->toArray();

		$this->set(compact('postalCodes'));
		$serialize = 'postalCodes';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function timezones() {
		$this->loadModel('Data.Timezones');
		$timezones = $this->Timezones->find('all')->toArray();

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
