<?php
namespace Sandbox\Controller;

use Sandbox\Controller\SandboxAppController;
use Cake\Event\Event;

class TryoutsController extends SandboxAppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * TryoutsController::fontawesome()
	 *
	 * @see http://fontawesome.io/
	 *
	 * @return void
	 */
	public function fontawesome() {
	}

	/**
	 * TryoutsController::fontello()
	 *
	 * @return void
	 */
	public function fontello() {
	}

}

