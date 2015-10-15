<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class SearchExamplesController extends SandboxAppController {

	public $modelClass = 'Sandbox.CountryRecords';

	public $components = ['Search.Prg'];

	public $helpers = ['Data.Data'];

	public function beforeFilter(Event $event) {
		$this->Auth->allow();

		parent::beforeFilter($event);
	}

	public function index() {
		$this->Prg->commonProcess();

		// Make sure we can download all at once if we want to
		$this->paginate['maxLimit'] = 999;

		$countries = $this->paginate($this->CountryRecords->find('searchable', $this->Prg->parsedParams()));
		$this->set(compact('countries'));
		$this->set('_serialize', ['countries']);
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

}
