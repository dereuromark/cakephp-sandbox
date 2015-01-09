<?php
namespace Sandbox\Controller;

use Sandbox\Controller\SandboxAppController;

class SearchExamplesController extends SandboxAppController {

	public $uses = array('Sandbox.CountryRecord');

	public $components = array('Search.Prg');

	public $helpers = array('Data.Data');

	public function beforeFilter(Event $event) {
		$this->Auth->allow();

		parent::beforeFilter($event);
	}

	public function index() {
		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->CountryRecord->parseCriteria($this->Prg->parsedParams());

		$countries = $this->paginate();
		$this->set(compact('countries'));
	}

}
