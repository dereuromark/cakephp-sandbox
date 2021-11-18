<?php

namespace Sandbox\Controller;

/**
 * @property \Icings\KnpMenu\Controller\Component\MenuComponent $Menu
 */
class MenuController extends SandboxAppController {

	/**
	 * @var array
	 */
	//protected $components = ['Gourmet/KnpMenu.Menu'];

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
