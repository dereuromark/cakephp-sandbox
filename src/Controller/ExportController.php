<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\ORM\TableRegistry;

/**
 * @property \Cache\Controller\Component\CacheComponent $Cache
 */
class ExportController extends AppController {

	/**
	 * @var array
	 */
	public $components = ['Cache.Cache'];

	/**
	 * ExportController::beforeFilter()
	 *
	 * @param \Cake\Event\Event $event
	 * @return \Cake\Http\Response|null
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (!$this->viewBuilder()->getClassName() || $this->viewBuilder()->getClassName() === 'View') {
			return null;
		}

		if ($this->referer(null, true) !== '/export') {
			throw new MethodNotAllowedException('Please do not use this as a webservice (the capacities are limited). Download the JSON or XML file and import it.');
		}
	}

	/**
	 * ExportController::afterFilter()
	 *
	 * @param \Cake\Event\Event $event
	 * @return \Cake\Http\Response|null
	 */
	public function afterFilter(Event $event) {
		parent::afterFilter($event);

		if ($this->request->query('download')) {
			$this->response->download($this->request->params['action'] . '.' . $this->request->params['ext']);
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
		$this->Countries = TableRegistry::get('Data.Countries');
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
		$this->States = TableRegistry::get('Data.States');
		$states = $this->States->find('all', ['fields' => []]);

		$this->set(compact('states'));
		$this->set('_serialize', ['states']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function currencies() {
		$this->Currency = TableRegistry::get('Data.Currencies');
		$currencies = $this->Currency->find('all', ['fields' => []]);

		$this->set(compact('currencies'));
		$this->set('_serialize', ['currencies']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function languages() {
		$this->Language = TableRegistry::get('Data.Languages');
		$languages = $this->Language->find('all', ['fields' => []]);

		$this->set(compact('languages'));
		$this->set('_serialize', ['languages']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function continents() {
		$this->Continent = TableRegistry::get('Data.Continents');
		$continents = $this->Continent->find('all', ['fields' => []]);

		$this->set(compact('continents'));
		$this->set('_serialize', ['continents']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function postalCodes() {
		$this->PostalCode = TableRegistry::get('Data.PostalCodes');
		$postalCodes = $this->PostalCode->find('all', ['fields' => []]);

		$this->set(compact('postalCodes'));
		$this->set('_serialize', ['postalCodes']);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function mimeTypes() {
	}

}
