<?php

namespace StateMachineSandbox\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use StateMachine\Business\StateMachineFacade;
use StateMachine\Dto\StateMachine\ItemDto;
use StateMachineSandbox\StateMachine\RegistrationStateMachineHandler;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \StateMachineSandbox\Model\Table\RegistrationsTable $Registrations
 */
class RegistrationDemoController extends AppController {

	/**
	 * @var string
	 */
	protected $modelClass = 'StateMachineSandbox.Registrations';

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function register() {
		$this->loadModel('Users');
		$users = $this->Users->find()
			->select(['Users.id', 'Users.username'])
			->where(['Users.username IN' => ['user', 'mod']])
			->find('list')
			->toArray();

		$registration = $this->Registrations->newEmptyEntity();
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			// We only do this so each demo run per user is independent
			$data['session_id'] = $this->request->getSession()->id();
			$registration = $this->Registrations->patchEntity($registration, $data);

			if ($this->Registrations->save($registration)) {
				$this->Flash->success('We received your registration. Please "simulate pay" now.');

				return $this->redirect(['action' => 'process', $registration->id]);
			}
		}

		$this->set(compact('users', 'registration'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function process() {
		$registrations = $this->Registrations->find()
			->where(['session_id' => $this->request->getSession()->id()])
			->contain(['Users', 'RegistrationStates'])
			->all()
			->toArray();

		$this->set(compact('registrations'));
	}

	/**
	 * @param string|int|null $id
	 * @throws \Cake\Http\Exception\NotFoundException
	 * @return \Cake\Http\Response|null|void
	 */
	public function moderatorPanel($id = null) {
		/** @var array<\StateMachineSandbox\Model\Entity\Registration> $registrations */
		$registrations = $this->Registrations->find()
			->where(['session_id' => $this->request->getSession()->id(), 'Registrations.status' => 'pending'])
			->contain(['Users', 'RegistrationStates'])
			->all()
			->toArray();

		if ($this->request->isPost()) {
			$stateMachineFacade = new StateMachineFacade();
			$itemDto = new ItemDto();
			$itemDto->setIdentifier($id);
			$registrationEntity = null;
			foreach ($registrations as $registration) {
				if ($registration->id === (int)$id) {
					$registrationEntity = $registration;

					break;
				}
			}
			if (!$registrationEntity) {
				throw new NotFoundException('No such registration');
			}

			$itemDto->setStateMachineName(RegistrationStateMachineHandler::NAME);
			$itemDto->setStateName(RegistrationStateMachineHandler::STATE_WAITING_FOR_APPROVAL);
			$itemDto->setProcessName($registrationEntity->registration_state->process);

			$stateMachineFacade->triggerEvent(RegistrationStateMachineHandler::EVENT_APPROVE, $itemDto);
			$this->Flash->success('Done! The state machine process will now continue on its own.');

			return $this->redirect(['action' => 'moderatorPanel']);
		}

		$this->set(compact('registrations'));
	}

	/**
	 * @param string|int|null $id
	 * @throws \Cake\Http\Exception\NotFoundException
	 * @return \Cake\Http\Response|null|void
	 */
	public function adminPanel($id = null) {
		$registrations = $this->Registrations->find()
			->where(['session_id' => $this->request->getSession()->id()])
			->contain(['Users', 'RegistrationStates'])
			->all()
			->toArray();

		if ($this->request->isPost()) {
			$stateMachineFacade = new StateMachineFacade();
			$itemDto = new ItemDto();
			$itemDto->setIdentifier($id);
			$registrationEntity = null;
			foreach ($registrations as $registration) {
				if ($registration->id === (int)$id) {
					$registrationEntity = $registration;

					break;
				}
			}
			if (!$registrationEntity) {
				throw new NotFoundException('No such registration');
			}

			$itemDto->setStateMachineName(RegistrationStateMachineHandler::NAME);
			$itemDto->setStateName(RegistrationStateMachineHandler::STATE_WAITING_FOR_PAYMENT);
			$itemDto->setProcessName($registrationEntity->registration_state->process);

			$stateMachineFacade->triggerEvent(RegistrationStateMachineHandler::EVENT_CONFIRM_PAYMENT, $itemDto);
			$this->Flash->success('Done! The state machine process will now continue on its own.');

			return $this->redirect(['action' => 'adminPanel']);
		}

		$this->provideAutoReleaseInfos($registrations);
		$this->provideQueuedJobs($registrations);

		$this->set(compact('registrations'));
	}

	/**
	 * @param int|null $id
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function removeJob($id = null) {
		$jobType = 'StateMachineSandbox.SimulatePaymentResult';
		$queuedJobsTable = $this->getTableLocator()->get('Queue.QueuedJobs');
		$queuedJob = $queuedJobsTable->get($id);
		if ($queuedJob->completed || $queuedJob->job_type !== $jobType || strpos($queuedJob->reference, 'registration-') !== 0) {
			throw new NotFoundException('Invalid queue job ID');
		}
		$queuedJobsTable->deleteOrFail($queuedJob);

		$this->Flash->success('Job removed');

		return $this->redirect(['action' => 'adminPanel']);
	}

	/**
	 * @param array<\StateMachineSandbox\Model\Entity\Registration> $registrations
	 * @return void
	 */
	protected function provideAutoReleaseInfos(array $registrations): void {
		$timeoutsTable = $this->getTableLocator()->get('StateMachine.StateMachineTimeouts');
		$timeouts = $timeoutsTable->find()
			->all()->toArray();

		$this->set(compact('timeouts'));
	}

	/**
	 * @param array<\StateMachineSandbox\Model\Entity\Registration> $registrations
	 * @return void
	 */
	protected function provideQueuedJobs(array $registrations): void {
		$references = [];
		foreach ($registrations as $registration) {
			$references[] = 'registration-' . $registration->id;
		}
		if (!$references) {
			return;
		}

		$jobTypes = [
			'StateMachineSandbox.SimulatePaymentResult',
		];
		$queuedJobsTable = $this->getTableLocator()->get('Queue.QueuedJobs');
		$queuedJobs = $queuedJobsTable->find()
			->where(['job_task IN' => $jobTypes, 'completed IS' => null, 'reference IN' => $references])
			->all()->toArray();

		$this->set(compact('queuedJobs'));
	}

}
