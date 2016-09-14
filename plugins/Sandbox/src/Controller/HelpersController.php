<?php
namespace Sandbox\Controller;

class HelpersController extends SandboxAppController {

	/**
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
