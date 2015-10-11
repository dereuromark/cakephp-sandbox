<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

/**
 * Start page controller.
 *
 * @deprecated See ChronosExamplesController (Chronos replaces Carbon)
 */
class CarbonController extends SandboxAppController {

	public $uses = [];

	public function beforeFilter(Event $event) {
		$this->Auth->allow('index');
	}

	public function index() {
	}

}
