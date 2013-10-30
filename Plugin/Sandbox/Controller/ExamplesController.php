<?php
App::uses('SandboxAppController', 'Sandbox.Controller');

class ExamplesController extends SandboxAppController {

	public $helpers = array('Geshi.Geshi', 'Tools.Piechart', 'Tools.Highslide');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/* just an index for all jquery examples */

	public function jquery() {
		$this->JqueryExample->recursive = 0;
		$this->set('examples', $this->JqueryExample->find('all'));
	}

	public function piechart() {
	}

	public function linefeed() {
	}

	public function highslide() {
	}

	public function geshi() {
	}

	public function params() {
	}

	public function configure_usage() {
	}

	public function translate_usage() {
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

	public function admin_index() {
		$this->Example->recursive = 1;
		$this->set('examples', $this->paginate());
	}

	public function admin_view($id = null) {
		if (!$id) {
			$this->Common->flashMessage(__('Invalid Example.'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('example', $this->Example->get($id));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Example->create();

			if ($this->Example->save($this->request->data)) {
				$this->Common->flashMessage(__('The Example has been saved'), 'success');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('The Example could not be saved. Please, try again.'), 'error');

		}
		$codesnippets = $this->Example->Codesnippet->find('list');
		$this->set(compact('codesnippets'));

		$this->request->data['Example']['active'] = 1;
		$this->request->data['Example']['published'] = date('Y-m-d');
	}

	public function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Common->flashMessage(__('Invalid Example'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Example->save($this->request->data)) {
				$this->Common->flashMessage(__('The Example has been saved'), 'success');
				return $this->redirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('The Example could not be saved. Please, try again.'), 'error');

		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Example->get($id);
		}
		$codesnippets = $this->Example->Codesnippet->find('list');
		$this->set(compact('codesnippets'));
	}

	public function admin_delete($id = null) {
		if (!$id) {
			$this->Common->flashMessage(__('Invalid id for Example'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->Example->delete($id)) {
			$this->Common->flashMessage(__('Example deleted'), 'xxxxx');
			return $this->redirect(array('action' => 'index'));
		}
	}

}

