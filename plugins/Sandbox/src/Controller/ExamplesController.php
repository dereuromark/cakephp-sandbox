<?php

namespace Sandbox\Controller;

class ExamplesController extends SandboxAppController {

	/**
	 * Lists all actions available.
	 *
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @return void
	 */
	public function params() {
	}

	/**
	 * @return void
	 */
	public function phpBasicfunctions() {
	}

	/**
	 * @return void
	 */
	public function phpValidationfunctions() {
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function messages() {
		return $this->redirect(['controller' => 'FlashExamples', 'action' => 'index'], 301);
	}

}
