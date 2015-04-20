<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class BootstrapController extends SandboxAppController {

	public $modelClass = 'Sandbox.Animals';

	public $components = ['Search.Prg'];

	public $helpers = ['Form' => ['className' => 'BootstrapUI.Form'], 'Flash' => ['className' => 'BootstrapUI.Flash']];

	public function initialize() {
		parent::initialize();
	}

	public function beforeFilter(Event $event) {
		unset($this->helpers['Tools.Form']);
		unset($this->helpers['Tools.Flash']);

		$this->Auth->allow();
		parent::beforeFilter($event);
	}

	public function index() {
		$animal = $this->Animals->newEntity();

		$this->set(compact('animal'));
	}

}
