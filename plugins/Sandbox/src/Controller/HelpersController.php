<?php

namespace Sandbox\Controller;

class HelpersController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function googleMapV3() {
		$this->viewBuilder()->setHelpers(['Geo.GoogleMap']);
	}

}
