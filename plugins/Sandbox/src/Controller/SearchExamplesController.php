<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

/**
 * @property \Sandbox\Model\Table\CountryRecordsTable $CountryRecords
 * @property \Search\Controller\Component\PrgComponent $Prg
 */
class SearchExamplesController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Sandbox.CountryRecords';

	/**
	 * @var array
	 */
	public $components = ['Search.Prg' => ['actions' => ['table']]];

	/**
	 * @var array
	 */
	public $helpers = ['Data.Data'];

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function table() {
		// Make sure we can download all at once if we want to
		$this->paginate['maxLimit'] = 999;

		$countries = $this->paginate($this->CountryRecords->find('search', ['search' => $this->request->getQuery()]));

		$this->set(compact('countries'));
		$this->set('_serialize', ['countries']);
	}

	/**
	 * @param \Cake\Event\Event $event
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function afterFilter(Event $event) {
		parent::afterFilter($event);

		if ($this->request->getQuery('download')) {
			$this->response->download($this->request->params['action'] . '.' . $this->request->params['_ext']);
		}
	}

}
