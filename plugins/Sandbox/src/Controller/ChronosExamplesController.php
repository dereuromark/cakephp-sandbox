<?php

namespace Sandbox\Controller;

use Cake\Chronos\Chronos;

/**
 * Start page controller.
 */
class ChronosExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$referenceString = null;
		if ($this->request->getData('now')) {
			$referenceString = $this->request->getData('now.year') . '-' . $this->request->getData('now.month') . '-' . $this->request->getData('now.day');
		}

		if (strlen($referenceString) !== 10) {
			$now = Chronos::now();
		} else {
			$now = new Chronos($referenceString);
		}

		$this->set(compact('now'));
	}

}
