<?php
declare(strict_types=1);

namespace StateMachineSandbox\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * @property \StateMachineSandbox\Model\Table\RegistrationsTable $Registrations
 * @method \Cake\Datasource\ResultSetInterface<\StateMachineSandbox\Model\Entity\Registration> paginate($object = null, array $settings = [])
 * @property \StateMachine\Model\Table\StateMachineTransitionLogsTable $StateMachineTransitionLogs
 * @property \StateMachine\Model\Table\StateMachineItemStateLogsTable $StateMachineItemStateLogs
 */
class RegistrationsController extends AppController {

	/**
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function index() {
		$this->paginate = [
			'contain' => ['Users', 'RegistrationStates'],
			'conditions' => [
				'session_id' => $this->request->getSession()->id(),
			],
		];
		$registrations = $this->paginate($this->Registrations);

		$this->set(compact('registrations'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Registration id.
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function view($id = null) {
		$registration = $this->Registrations->get($id, [
			'contain' => ['Users', 'RegistrationStates' => 'StateMachineTransitionLogs'],
		]);
		if ($registration->session_id !== $this->request->getSession()->id()) {
			throw new NotFoundException();
		}

		$this->loadModel('StateMachine.StateMachineTransitionLogs');
		$logs = $this->StateMachineTransitionLogs->getLogs($registration->registration_state->id);

		$this->loadModel('StateMachine.StateMachineItemStateLogs');
		$history = $this->StateMachineItemStateLogs->getHistory($registration->registration_state);

		$this->set(compact('registration', 'logs', 'history'));
	}

	/**
	 * @param string|null $id Registration id.
	 * @return \Cake\Http\Response|null|void Redirects to index.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$registration = $this->Registrations->get($id);
		if ($registration->session_id !== $this->request->getSession()->id()) {
			throw new NotFoundException();
		}

		if ($this->Registrations->delete($registration)) {
			$this->Flash->success(__('The registration has been deleted.'));
		} else {
			$this->Flash->error(__('The registration could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

}
