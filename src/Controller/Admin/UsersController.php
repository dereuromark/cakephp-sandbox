<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

class UsersController extends AppController {

	public function index() {
		$this->set('users', $this->paginate());
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The User has been saved'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('The User could not be saved. Please, try again.'));
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

	public function edit($id = null) {
		$id = (int)$id;
		if ($id <= 0 && empty($this->request->data)) {
			$this->Flash->error(__('Invalid User'));
			return $this->redirect(['action' => 'index']);
		}
		if ($this->Common->isPosted()) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The User has been saved'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('The User could not be saved. Please, try again.'));
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->User->get($id);
		}
	}

	public function delete($id = null) {
		$id = (int)$id;
		if ($id <= 0) {
			$this->Flash->error(__('Invalid id for User'));
			return $this->redirect(['action' => 'index']);
		}
		if ($this->User->delete($id)) {
			$this->Flash->message(__('User deleted'), 'xxxxx');
			return $this->redirect(['action' => 'index']);
		}
	}

}
