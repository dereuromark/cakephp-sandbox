<?php
namespace Sandbox\Controller;

use Sandbox\Controller\SandboxAppController;
use Cake\Event\Event;

class SearchExamplesController extends SandboxAppController {

	public $modelClass = 'Sandbox.CountryRecords';

	public $components = array('Search.Prg');

	public $helpers = array('Data.Data');

	public function beforeFilter(Event $event) {
		$this->Auth->allow();

		parent::beforeFilter($event);
	}

	public function index() {
		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->CountryRecords->find('searchable', $this->Prg->parsedParams());

		$countries = $this->paginate();
		$this->set(compact('countries'));
	}

}
