<?php

namespace Sandbox\Controller;

use Cake\Event\Event;
use Cake\Event\EventInterface;

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
	protected $components = ['Search.Prg' => ['actions' => ['table']]];

	/**
	 * @var array
	 */
	protected $helpers = ['Data.Data'];

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
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function afterFilter(EventInterface $event) {
		parent::afterFilter($event);

		if ($this->request->getQuery('download')) {
			$this->response->download($this->request->getParam('action') . '.' . $this->request->getParam('_ext'));
		}
	}

}
