<?php
use Sandbox\Controller\SandboxAppController;

class TryoutsController extends SandboxAppController {

	public function beforeFilter() {
		parent::beforeFilter();

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

