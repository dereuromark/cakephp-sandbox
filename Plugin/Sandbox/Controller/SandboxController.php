<?php
use Sandbox\Controller\SandboxAppController;

class SandboxController extends SandboxAppController {

	public $uses = array();

	public function beforeFilter(Event $event) {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	/**
	 * Overview
	 *
	 * @return void
	 */
	public function index() {
	}

	public function admin_index() {
		$methods = $this->_getActions($this);

		$this->set(compact('methods'));
	}

}
