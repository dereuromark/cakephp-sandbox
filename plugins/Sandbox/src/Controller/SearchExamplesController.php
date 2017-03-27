<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

/**
 * @property \Sandbox\Model\Table\CountryRecordsTable $CountryRecords
 */
class SearchExamplesController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Sandbox.CountryRecords';

	/**
	 * @var array
	 */
	public $components = ['Search.Prg'];

	/**
	 * @var array
	 */
	public $helpers = ['Data.Data'];

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
	 * @param \Cake\Event\Event $event
	 *
	 * @return \Cake\Network\Response|null|void
	 */
	public function afterFilter(Event $event) {
		parent::afterFilter($event);

		if ($this->request->query('download')) {
			$this->response->download($this->request->params['action'] . '.' . $this->request->params['_ext']);
		}
	}

}
