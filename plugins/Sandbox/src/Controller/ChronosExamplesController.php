<?php
namespace Sandbox\Controller;

use Cake\Event\Event;
use Cake\Chronos\Chronos;

/**
 * Start page controller.
 */
class ChronosExamplesController extends SandboxAppController {

	public $uses = [];

	public function beforeFilter(Event $event) {
		$this->Auth->allow('index');
	}

	public function index() {
		$referenceString = null;
		if (!empty($this->request->data['now'])) {
			$referenceString = $this->request->data['now']['year'] . '-' . $this->request->data['now']['month'] . '-' . $this->request->data['now']['day'];
		}


		if (strlen($referenceString) !== 10) {
			$now = Chronos::now();
		} else {
			$now = new Chronos($referenceString);
		}

		$this->set(compact('now'));
	}

}
