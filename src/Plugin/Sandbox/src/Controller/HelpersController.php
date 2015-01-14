<?php
namespace Sandbox\Controller;

class HelpersController extends SandboxAppController {

	public $uses = array();

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * 2010-07-24 ms
	 */
	public function index() {
	}

	/**
	 * GoogleMapV3Helper
	 */
	public function google_map_v3() {
		$this->Common->loadHelper(array('Tools.GoogleMapV3'));
	}

}
