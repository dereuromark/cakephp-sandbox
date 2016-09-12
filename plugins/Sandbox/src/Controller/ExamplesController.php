<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

class ExamplesController extends SandboxAppController {

	public $helpers = ['Markup.Highlighter'];

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

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function markup() {
		//throw new NotFoundException('Currently disabled because they cannot provide a stable composer tag.');
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
