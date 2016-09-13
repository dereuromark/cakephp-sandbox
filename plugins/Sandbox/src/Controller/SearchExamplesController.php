<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class SearchExamplesController extends SandboxAppController {

	public $modelClass = 'Sandbox.CountryRecords';

	public $components = ['Search.Prg'];

	public $helpers = ['Data.Data'];

	/**
	 * @param \Cake\Event\Event $event
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * @return void
	 */
	public function index() {
		// Make sure we can download all at once if we want to
		$this->paginate['maxLimit'] = 999;

		$countries = $this->paginate($this->CountryRecords->find('search', ['search' => $this->request->query]));
		$isSearch = $this->CountryRecords->isSearch();
		$this->set(compact('countries', 'isSearch'));
		$this->set('_serialize', ['countries']);
	}

	/**
	 * @param Event $event
	 *
	 * @return \Cake\Network\Response|null|void
	 */
	public function afterFilter(Event $event) {
		parent::afterFilter($event);

		if ($this->request->query('download')) {
			$this->response->download($this->request->params['action'] . '.' . $this->request->params['ext']);
		}
	}

}
