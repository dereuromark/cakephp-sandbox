<?php
namespace Sandbox\Controller;

class HelpersController extends SandboxAppController {

	public $uses = [];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * 2010-07-24 ms
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * GoogleMapV3Helper
	 *
	 * @return void
	 */
	public function google_map_v3() {
		$this->Common->loadHelper(['Tools.GoogleMapV3']);
	}

}
