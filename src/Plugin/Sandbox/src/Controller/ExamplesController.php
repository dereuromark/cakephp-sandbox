<?php
namespace Sandbox\Controller;

class ExamplesController extends SandboxAppController {

	public $helpers = array('Geshi.Geshi');

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

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
		$this->Flash->message('An error occured somewhere - mabye', 'error');
		$this->Flash->message('This is a warning...', 'warning');
		$this->Flash->message('This is a second very interesting warning', 'warning');
		$this->Flash->message('Good Job :) You did it', 'success');
		$this->Flash->message('I am a info message for you', 'info');
	}

}
