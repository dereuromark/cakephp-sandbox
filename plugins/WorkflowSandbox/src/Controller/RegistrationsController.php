<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Response;
use Workflow\Service\TransitionLogger;
use Workflow\Service\WorkflowRegistry;

/**
 * Registrations Controller
 *
 * Demo for Registration workflow.
 *
 * @property \WorkflowSandbox\Model\Table\RegistrationsTable $Registrations
 * @property \Workflow\Controller\Component\WorkflowComponent $Workflow
 */
class RegistrationsController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->Registrations = $this->fetchTable('WorkflowSandbox.Registrations');
		$this->loadComponent('Workflow.Workflow');
	}

	/**
	 * Get the workflow registry.
	 *
	 * @return \Workflow\Service\WorkflowRegistry
	 */
	protected function getRegistry(): WorkflowRegistry {
		return Configure::read('WorkflowSandbox.registry');
	}

	/**
	 * Index - List registrations and show workflow diagram.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index(): ?Response {
		$registrations = $this->Registrations->find()
			->contain(['Users'])
			->orderByDesc('Registrations.created')
			->limit(20)
			->all()
			->toArray();

		$definition = $this->getRegistry()->getWorkflow('registration');
		$users = $this->fetchTable('Users')->find('list')->toArray();

		$this->set(compact('registrations', 'definition', 'users'));

		return null;
	}

	/**
	 * Create a new registration.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function add(): ?Response {
		$registration = $this->Registrations->newEmptyEntity();

		if ($this->request->is('post')) {
			$registration = $this->Registrations->patchEntity($registration, $this->request->getData());
			$registration->session_id = session_id() ?: null;
			$registration->status = 'pending';

			if ($this->Registrations->save($registration)) {
				$this->Flash->success(__('Registration created. Status: pending'));

				return $this->redirect(['action' => 'view', $registration->id]);
			}
			$this->Flash->error(__('Could not create registration.'));
		}

		$users = $this->fetchTable('Users')->find('list')->toArray();
		$this->set(compact('registration', 'users'));

		return null;
	}

	/**
	 * View a registration.
	 *
	 * @param int|null $id Registration ID
	 * @return \Cake\Http\Response|null
	 */
	public function view(?int $id = null): ?Response {
		$registration = $this->Registrations->get($id, contain: ['Users']);
		$definition = $this->getRegistry()->getWorkflow('registration');
		$availableTransitions = $this->Registrations->getAvailableTransitions($registration);

		// Get transition history
		$logger = new TransitionLogger();
		$transitionHistory = $logger->getHistory('registration', 'WorkflowSandbox.Registrations', (string)$registration->id);

		$this->set(compact('registration', 'definition', 'availableTransitions', 'transitionHistory'));

		return null;
	}

	/**
	 * Apply a transition to a registration.
	 *
	 * Uses the WorkflowComponent for standardized flash messages.
	 * With autoSave and autoLog enabled on the behavior:
	 * - applyTransition() runs workflow commands
	 * - autoSave saves the entity
	 * - autoLog logs the transition
	 *
	 * @param int $id Registration ID
	 * @return \Cake\Http\Response
	 */
	public function transition(int $id): Response {
		$this->request->allowMethod(['post']);

		$registration = $this->Registrations->get($id);

		return $this->Workflow->handleTransition(
			$this->Registrations,
			$registration,
			['action' => 'view', $id],
		);
	}

	/**
	 * Delete a registration.
	 *
	 * @param int|null $id Registration ID
	 * @return \Cake\Http\Response|null
	 */
	public function delete(?int $id = null): ?Response {
		$this->request->allowMethod(['post', 'delete']);

		$registration = $this->Registrations->get($id);

		if ($this->Registrations->delete($registration)) {
			$this->Flash->success(__('Registration deleted.'));
		} else {
			$this->Flash->error(__('Could not delete registration.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Reset all registrations (for demo purposes).
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function reset(): ?Response {
		$this->request->allowMethod(['post']);

		$this->Registrations->deleteAll([]);
		$this->Flash->success(__('All registrations reset.'));

		return $this->redirect(['action' => 'index']);
	}

}
