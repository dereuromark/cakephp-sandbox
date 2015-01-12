<?php
namespace Sandbox\Controller;

use Sandbox\Controller\SandboxAppController;
use Cake\Event\Event;
use Cake\Utility\Hash;

class PluginExamplesController extends SandboxAppController {

	public $helpers = array('Geshi.Geshi');

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

