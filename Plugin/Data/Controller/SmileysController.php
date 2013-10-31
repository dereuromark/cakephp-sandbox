<?php
App::uses('DataAppController', 'Data.Controller');
class SmileysController extends DataAppController {

	public $paginate = array('order' => array('Smiley.is_base' => 'DESC', 'Smiley.sort' => 'ASC'), 'limit' => 100);

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	public function admin_index() {
		$this->Smiley->recursive = 0;
		$smileys = $this->paginate();
		$this->set(compact('smileys'));
	}

	public function admin_view($id = null) {
		if (empty($id) || !($smiley = $this->Smiley->find('first', array('conditions' => array('Smiley.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('smiley'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Smiley->create();
			if ($this->Smiley->save($this->request->data)) {
				$var = $this->Smiley->id; //$this->request->data['Smiley']['name'];
				$this->Common->flashMessage(__('record add %s saved', h($var)), 'success');
				return $this->Common->autoRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
	}

	public function admin_edit($id = null) {
		if (empty($id) || !($smiley = $this->Smiley->find('first', array('conditions' => array('Smiley.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Smiley->save($this->request->data)) {
				$var = $id; //$this->request->data['Smiley']['name'];
				$this->Common->flashMessage(__('record edit %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $smiley;
		}
	}

	public function admin_delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id) || !($smiley = $this->Smiley->find('first', array('conditions' => array('Smiley.id' => $id), 'fields' => array('id'))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Smiley->delete($id)) {
			$var = $smiley['Smiley']['id'];
			$this->Common->flashMessage(__('record del %s done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

	/**
	 * Toggle - ajax
	 */
	public function admin_toggle($field = null, $id = null) {
		 $fields = array('active');

		if (!empty($field) && in_array($field, $fields) && !empty($id)) {
			$value = $this->{$this->modelClass}->toggleField($field, $id);
		}
		$model = $this->{$this->modelClass}->alias;

		if (!$this->request->is('ajax')) {
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->autoRender = false;
		if (isset($value)) {
			$this->set('ajaxToggle', $value);
			$this->set(compact('field', 'model'));

			$this->render('admin_toggle', 'ajax');
		}
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
