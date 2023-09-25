<?php

namespace Sandbox\Controller;

use Cake\Datasource\ModelAwareTrait;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\View\JsonView;
use Cake\View\XmlView;
use Shim\Datasource\LegacyModelAwareTrait;

/**
 * @property \Sandbox\Model\Table\CountryRecordsTable $CountryRecords
 * @property \Search\Controller\Component\SearchComponent $Search
 */
#[\AllowDynamicProperties]
class SearchExamplesController extends SandboxAppController {

	use ModelAwareTrait;
	use LegacyModelAwareTrait;

	/**
	 * @var string
	 */
	protected ?string $defaultTable = 'Sandbox.CountryRecords';

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

		$query = $this->CountryRecords->find('search', search: $this->request->getQuery());
		$countries = $this->paginate($query);

		$this->set(compact('countries'));
		//$this->set('_serialize', ['countries']);
		$serialize = 'countries';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function afterFilter(EventInterface $event): ?Response {
		parent::afterFilter($event);

		if ($this->request->getQuery('download')) {
			$this->response = $this->response->withDownload($this->request->getParam('action') . '.' . $this->request->getParam('_ext'));
		}

		return null;
	}

}
