<?php
namespace Sandbox\Controller;

use Sandbox\Controller\SandboxAppController;
use Cake\Event\Event;

class JsExamplesController extends SandboxAppController {

	public function beforeFilter(Event $event) {
		$this->Auth->allow();

		parent::beforeFilter($event);
	}

	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

}
