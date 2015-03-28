<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class ConventionsController extends SandboxAppController {

	public $uses = ['User'];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * @see http://groups.google.com/group/cake-php/browse_thread/thread/6908dce4d55c1a5d
	 * //TODO
	 * 2010-07-24 ms
	 */
	public function index() {
	}

}
