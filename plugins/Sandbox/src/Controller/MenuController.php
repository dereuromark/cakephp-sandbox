<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class MenuController extends SandboxAppController {

	public $components = ['Gourmet/KnpMenu.Menu'];
	public $helpers = ['Gourmet/KnpMenu.Menu'];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow();
	}

	/**
	 * PluginExamplesController::index()
	 *
	 * @return void
	 */
	public function index() {
		$menu = $this->Menu->get('my_menu');

		$menu->addChild('Dashboard',
			['uri' => ['plugin' => false, 'controller' => 'Overview', 'action' => 'index']]);
		$menu->addChild('Sandbox');
		$menu->addChild('Coming soon');

		$menu['Sandbox']->setUri('#sandbox');
		$menu['Sandbox']->addChild('Overview', ['uri' => ['plugin' => 'Sandbox', 'controller' => 'Sandbox', 'action' => 'index']]);
	}

}
