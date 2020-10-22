<?php

namespace Sandbox\Controller;

class MarkupExamplesController extends SandboxAppController {

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
	 * @return void
	 */
	public function markdown() {
		$this->viewBuilder()->addHelper('Markup.Markdown');
	}

	/**
	 * @return void
	 */
	public function bbcode() {
		$this->viewBuilder()->addHelper('Markup.Bbcode');
	}

}
