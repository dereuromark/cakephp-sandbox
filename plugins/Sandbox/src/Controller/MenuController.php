<?php

namespace Sandbox\Controller;

/**
 * @property \Gourmet\KnpMenu\Controller\Component\MenuComponent $Menu
 */
class MenuController extends SandboxAppController {
	/**
	 * @var array
	 */
	protected $components = ['Gourmet/KnpMenu.Menu'];

	/**
	 * @var array
	 */
	protected $helpers = ['Gourmet/KnpMenu.Menu'];

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
		$menu['Sandbox']->addChild('Menu Index', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index']]);
		$menu['Sandbox']->addChild('Menu Index with Passed Param', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index', 'foo']]);
		$menu['Sandbox']->addChild('Menu Index with Query String', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index', '?' => ['foo' => 'bar']]]);
	}

}
