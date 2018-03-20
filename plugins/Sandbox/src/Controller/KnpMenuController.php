<?php
namespace Sandbox\Controller;

/**
 * @property \Gourmet\KnpMenu\Controller\Component\MenuComponent $Menu
 */
class KnpMenuController extends SandboxAppController {

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
		$menu['Sandbox']->addChild('Menu Index', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index']]);
		$menu['Sandbox']->addChild('Menu Index with Passed Param', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index', 'foo']]);
		$menu['Sandbox']->addChild('Menu Index with Query String', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index', '?' => ['foo' => 'bar']]]);
	}

}
