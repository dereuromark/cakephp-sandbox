<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function index() {
		$this->paginate = [
			'contain' => ['Roles']
		];
		$this->set('users', $this->paginate());
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function add() {
		$user = $this->Users->newEntity();

		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		if ($this->Common->isPosted()) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The User has been saved'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('The User could not be saved. Please, try again.'));
		}
		$roles = $this->Users->Roles->find('list');
		$this->set(compact('roles', 'user'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
	 */
	public function edit($id = null) {
		$user = $this->Users->get($id);

		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false, 'require' => false]);
		if ($this->Common->isPosted()) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The User has been saved'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('The User could not be saved. Please, try again.'));
		}

		$roles = $this->Users->Roles->find('list');
		$this->set(compact('roles', 'user'));
	}

	/**
	 * @param int|null $id
	 * @return \Cake\Http\Response
	 */
	public function delete($id = null) {
		$user = $this->Users->get($id);

		$this->Users->delete($user);
		$this->Flash->success(__('User deleted'));
		return $this->redirect(['action' => 'index']);
	}

}
