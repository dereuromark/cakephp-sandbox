<?php
use Sandbox\Controller\SandboxAppController;

class ConventionsController extends SandboxAppController {

	public $uses = array('User');

	public function beforeFilter() {
		parent::beforeFilter();

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
