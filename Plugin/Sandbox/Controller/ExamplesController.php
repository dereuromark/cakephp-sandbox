<?php
App::uses('SandboxAppController', 'Sandbox.Controller');

class ExamplesController extends SandboxAppController {

	public $helpers = array('Geshi.Geshi');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	/**
	 * Lists all actions available.
	 *
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	public function geshi() {
	}

	public function params() {
	}

	public function php_basicfunctions() {
	}

	public function php_validationfunctions() {
	}

	public function php_arraycount() {
	}

	public function activecalendar() {
		if (!empty($this->request->params['named']['style'])) {
			$this->set('active_style', $this->request->params['named']['style']);
		}
	}

	public function messages() {
		$this->Common->flashMessage('An error occured somewhere - mabye', 'error');
		$this->Common->flashMessage('This is a warning...', 'warning');
		$this->Common->flashMessage('This is a second very interesting warning', 'warning');
		$this->Common->flashMessage('Good Job :) You did it', 'success');
		$this->Common->flashMessage('I am a info message for you', 'info');
	}

}

