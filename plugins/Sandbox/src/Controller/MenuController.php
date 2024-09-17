<?php

namespace Sandbox\Controller;

class MenuController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->addHelpers(['Icings/Menu.Menu']);
	}

	/**
	 * @return void
	 */
	public function index() {
	}

}
