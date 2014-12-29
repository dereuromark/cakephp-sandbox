<?php
use Sandbox\Controller\SandboxAppController;

class JsExamplesController extends SandboxAppController {

	public function beforeFilter(Event $event) {
		$this->Auth->allow();

		parent::beforeFilter();
	}

	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

}
