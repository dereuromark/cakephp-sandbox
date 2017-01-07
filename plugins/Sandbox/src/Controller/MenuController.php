<?php
namespace Sandbox\Controller;

class MenuController extends SandboxAppController {

	/**
	 * @var array
	 */
	public $components = ['Gourmet/KnpMenu.Menu'];

	/**
	 * @var array
	 */
	public $helpers = ['Gourmet/KnpMenu.Menu'];

	/**
	 * @return void
	 */
	public function index() {
		$menu = $this->Menu->get('my_menu');

		$menu->addChild('Dashboard',
			['uri' => ['plugin' => false, 'controller' => 'Overview', 'action' => 'index']]);
		$menu->addChild('Sandbox');
		$menu->addChild('Coming soon');

		$menu['Sandbox']->setUri(['plugin' => 'Sandbox', 'controller' => 'Sandbox', 'action' => 'index']);
		$menu['Sandbox']->addChild('Bootstrap', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Bootstrap', 'action' => 'index']]);
		$menu['Sandbox']->addChild('Menu', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index']]);
	}

}
