<?php
namespace Sandbox\Controller;

class ExamplesController extends SandboxAppController {

	/**
	 * @var array
	 */
	public $helpers = ['Markup.Highlighter'];

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

	/**
	 * @return void
	 */
	public function params() {
	}

	/**
	 * @return void
	 */
	public function phpBasicfunctions() {
	}

	/**
	 * @return void
	 */
	public function phpValidationfunctions() {
	}

	/**
	 * @return void
	 */
	public function phpArraycount() {
	}

	/**
	 * @return void
	 */
	public function activecalendar() {
		if (!empty($this->request->params['named']['style'])) {
			$this->set('active_style', $this->request->params['named']['style']);
		}
	}

	/**
	 * @return void
	 */
	public function messages() {
		$this->Flash->message('An error occured somewhere - mabye', 'error');
		$this->Flash->message('This is a warning...', 'warning');
		$this->Flash->message('This is a second very interesting warning', 'warning');
		$this->Flash->message('Good Job :) You did it', 'success');
		$this->Flash->message('I am a info message for you', 'info');
	}

}
