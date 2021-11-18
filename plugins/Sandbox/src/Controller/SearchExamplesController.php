<?php

namespace Sandbox\Controller;

use Cake\Event\EventInterface;

/**
 * @property \Sandbox\Model\Table\CountryRecordsTable $CountryRecords
 * @property \Search\Controller\Component\SearchComponent $Search
 */
class SearchExamplesController extends SandboxAppController {

	/**
	 * @var string
	 */
	protected $modelClass = 'Sandbox.CountryRecords';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Search.Search', [
			'actions' => ['table'],
		]);

		$this->viewBuilder()->addHelpers(['Data.Data']);
	}

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

		$query = $this->CountryRecords->find('search', ['search' => $this->request->getQuery()]);
		$countries = $this->paginate($query)->toArray();

		$this->set(compact('countries'));
		$this->set('_serialize', ['countries']);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function afterFilter(EventInterface $event) {
		parent::afterFilter($event);

		if ($this->request->getQuery('download')) {
			$this->response = $this->response->withDownload($this->request->getParam('action') . '.' . $this->request->getParam('_ext'));
		}
	}

}
