<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class PluginExamplesController extends SandboxAppController {

	public $helpers = [];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * PluginExamplesController::index()
	 *
	 * @return void
	 */
	public function index() {
	}

}
