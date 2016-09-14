<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class JsExamplesController extends SandboxAppController {

	/**
	 * @return void
     */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

}
