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
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	public function form() {
		$animal = $this->Animals->newEntity();

		$this->set(compact('animal'));
	}

	public function localized() {
		$animal = $this->Animals->newEntity();

		// This hack is needed to prevent the forms from being autofilled with todays date
		$this->request->data['discovered'] = '';
		$this->request->data['published'] = '';
		$this->request->data['time'] = '';

		$this->set(compact('animal'));
	}

}
