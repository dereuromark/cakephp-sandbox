<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class SandboxController extends SandboxAppController {

	public $modelClass = false;

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

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
