<?php

namespace Sandbox\Controller;

use Cake\TwigView\View\TwigView;

class TwigExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		if ($this->request->getParam('action') !== 'index') {
			$this->viewBuilder()->setClassName(TwigView::class);
			$this->viewBuilder()->setLayout('Sandbox.default');

			// Still needed for now?
			$this->viewBuilder()->setHelpers(['Flash', 'Text', 'Html', 'Url']);
		}
	}

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function basic() {
		$myText = <<<TXT
This is a short sentence.

But this is a longer one, so it needs its own paragraph. Awesome, right?
TXT;

		$this->set(compact('myText'));
	}

}
