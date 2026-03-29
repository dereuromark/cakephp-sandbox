<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Http\Response;
use RuntimeException;
use Workflow\Service\TransitionLogger;
use Workflow\Service\WorkflowRegistry;
use Workflow\Service\WorkflowRegistryLocator;

/**
 * Tickets Controller
 *
 * Demo for Support Ticket workflow.
 *
 * @property \WorkflowSandbox\Model\Table\TicketsTable $Tickets
 * @property \Workflow\Controller\Component\WorkflowComponent $Workflow
 */
class TicketsController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->Tickets = $this->fetchTable('WorkflowSandbox.Tickets');
		$this->loadComponent('Workflow.Workflow');
	}

	/**
	 * Get the workflow registry.
	 *
	 * @return \Workflow\Service\WorkflowRegistry
	 */
	protected function getRegistry(): WorkflowRegistry {
		return WorkflowRegistryLocator::get() ?? throw new RuntimeException('Workflow registry not configured');
	}

	/**
	 * Index - List tickets and show workflow diagram.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index(): ?Response {
		$tickets = $this->Tickets->find()
			->contain(['Users', 'Assignees'])
			->orderByDesc('Tickets.created')
			->limit(20)
			->all()
			->toArray();

		$definition = $this->getRegistry()->getWorkflow('ticket');
		$users = $this->fetchTable('Users')->find('list')->toArray();

		$this->set(compact('tickets', 'definition', 'users'));

		return null;
	}

	/**
	 * Create a new ticket.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function add(): ?Response {
		$ticket = $this->Tickets->newEmptyEntity();

		if ($this->request->is('post')) {
			$ticket = $this->Tickets->patchEntity($ticket, $this->request->getData());
			$ticket->ticket_number = $this->Tickets->generateTicketNumber();
			$ticket->status = 'open';

			if ($this->Tickets->save($ticket)) {
				$this->Flash->success(__('Ticket {0} created.', $ticket->ticket_number));

				return $this->redirect(['action' => 'view', $ticket->id]);
			}
			$this->Flash->error(__('Could not create ticket.'));
		}

		$users = $this->fetchTable('Users')->find('list')->toArray();
		$priorities = $this->Tickets::PRIORITIES;
		$this->set(compact('ticket', 'users', 'priorities'));

		return null;
	}

	/**
	 * View a ticket.
	 *
	 * @param int|null $id Ticket ID
	 * @return \Cake\Http\Response|null
	 */
	public function view(?int $id = null): ?Response {
		$ticket = $this->Tickets->get($id, contain: ['Users', 'Assignees']);
		$definition = $this->getRegistry()->getWorkflow('ticket');
		$availableTransitions = $this->Tickets->getAvailableTransitions($ticket);
		$users = $this->fetchTable('Users')->find('list')->toArray();

		// Get transition history
		$logger = new TransitionLogger();
		$transitionHistory = $logger->getHistory('ticket', 'WorkflowSandbox.Tickets', (string)$ticket->id);

		$this->set(compact('ticket', 'definition', 'availableTransitions', 'users', 'transitionHistory'));

		return null;
	}

	/**
	 * Apply a transition to a ticket.
	 *
	 * Uses the WorkflowComponent for standardized flash messages.
	 * Pre-transition logic sets entity fields from form data before transition.
	 *
	 * @param int $id Ticket ID
	 * @return \Cake\Http\Response
	 */
	public function transition(int $id): Response {
		$this->request->allowMethod(['post']);

		$ticket = $this->Tickets->get($id);
		$transitionName = (string)$this->request->getData('transition');

		// For 'assign' transition, set assignee from form data before transition
		if ($transitionName === 'assign' && $this->request->getData('assignee_id')) {
			$ticket->assignee_id = $this->request->getData('assignee_id');
		}

		$this->Workflow->applyTransition($this->Tickets, $ticket, $transitionName, [
			'reason' => $this->request->getData('reason') ?: 'Manual transition',
		]);

		/** @var \Cake\Http\Response */
		return $this->redirect(['action' => 'view', $id]);
	}

	/**
	 * Delete a ticket.
	 *
	 * @param int|null $id Ticket ID
	 * @return \Cake\Http\Response|null
	 */
	public function delete(?int $id = null): ?Response {
		$this->request->allowMethod(['post', 'delete']);

		$ticket = $this->Tickets->get($id);

		if ($this->Tickets->delete($ticket)) {
			$this->Flash->success(__('Ticket deleted.'));
		} else {
			$this->Flash->error(__('Could not delete ticket.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Reset all tickets (for demo purposes).
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function reset(): ?Response {
		$this->request->allowMethod(['post']);

		$this->Tickets->deleteAll([]);
		$this->Flash->success(__('All tickets reset.'));

		return $this->redirect(['action' => 'index']);
	}

}
