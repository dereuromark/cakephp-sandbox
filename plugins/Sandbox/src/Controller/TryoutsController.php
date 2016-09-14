<?php
namespace Sandbox\Controller;

class TryoutsController extends SandboxAppController {

	/**
	 * @return void
	 */
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
