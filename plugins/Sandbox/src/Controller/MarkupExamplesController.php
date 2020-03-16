<?php

namespace Sandbox\Controller;

class MarkupExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->setHelpers(['Markup.Highlighter']);
	}

	/**
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @return void
	 */
	public function markup() {
	}

	/**
	 * @see http://fontawesome.io/
	 *
	 * @return void
	 */
	public function markdown() {
	}

}
