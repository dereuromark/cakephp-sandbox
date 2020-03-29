<?php

namespace Sandbox\Controller;

use Cake\TwigView\View\TwigView;

class TwigExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->setClassName(TwigView::class);
		$this->viewBuilder()->setLayout('Sandbox.default');
	}

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

}
