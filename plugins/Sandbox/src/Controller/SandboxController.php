<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class SandboxController extends SandboxAppController {

	/**
	 * @var string|bool
	 */
	public $modelClass = false;

	/**
	 * @param \Cake\Event\Event $event
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * @return void
	 */
	public function index() {
	}

}
