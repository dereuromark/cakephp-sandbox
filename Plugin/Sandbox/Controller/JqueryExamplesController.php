<?php
App::uses('SandboxAppController', 'Sandbox.Controller');

class JqueryExamplesController extends SandboxAppController {

	public $helpers = array('Geshi.Geshi');

	public $uses = array();

	public $jqueryPlugins = array('media');

	public function beforeFilter() {
		$this->Auth->allow();

		parent::beforeFilter();
	}

	public function beforeRender() {
		$this->set('jquery_plugins', $this->jqueryPlugins);

		parent::beforeRender();
	}

	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

/**
 * JqueryExamplesController::autopreview()
 *
 * @return void
 */
	public function autopreview() {
	}

/**
 * JqueryExamplesController::maxlength()
 *
 * @return void
 */
	public function maxlength() {
	}

/**
 * Example of an autocomplete field using jQueryUI autocomplete with JSON
 * and AJAX
 *
 * @return mixed void || JSON
 */
	public function autocomplete() {
		if ($this->request->is('ajax')) {
			$this->loadModel('Sandbox.Animal');
			$items = $this->Animal->find('list', [
				'conditions' => [
					'name LIKE "%' . $this->request->query['term'] . '%"'
				]
			]);

			$this->set('items', $items);
			$this->set('_serialize', ['items']);
		}
	}

}

