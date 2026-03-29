<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Workflow\Service\TransitionLogger;
use Workflow\Service\WorkflowRegistry;

/**
 * Tickets Controller
 *
 * Demo for Support Ticket workflow.
 *
 * @property \WorkflowSandbox\Model\Table\TicketsTable $Tickets
 */
class TicketsController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->Tickets = $this->fetchTable('WorkflowSandbox.Tickets');
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
	 * @param int|null $id Ticket ID
	 * @return \Cake\Http\Response|null
	 */
	public function transition(?int $id = null): ?Response {
		$this->request->allowMethod(['post']);

		$ticket = $this->Tickets->get($id);
		$transition = $this->request->getData('transition');

		if (!$transition) {
			$this->Flash->error(__('No transition specified.'));

			return $this->redirect(['action' => 'view', $id]);
		}

		// Handle special transitions
		if ($transition === 'assign') {
			$assigneeId = $this->request->getData('assignee_id');
			if ($assigneeId) {
				$ticket->assignee_id = $assigneeId;
			}
		}

		$result = $this->Tickets->applyTransition($ticket, $transition);

		if ($result->isSuccess()) {
			if ($transition === 'escalate') {
				$ticket->escalated_at = new DateTime();
			} elseif ($transition === 'resolve') {
				$ticket->resolved_at = new DateTime();
			} elseif ($transition === 'reopen') {
				$ticket->resolved_at = null;
			}

			$this->Tickets->save($ticket);

			// Log the transition
			$logger = new TransitionLogger();
			$logger->log(
				'ticket',
				'WorkflowSandbox.Tickets',
				$ticket,
				$result,
				$transition,
				['user_id' => $this->request->getData('approver_id')],
			);

			$this->Flash->success(__('Transition "{0}" applied. New status: {1}', $transition, $ticket->status));
		} elseif ($result->isBlocked()) {
			$blockedBy = implode(', ', $result->getBlockedBy());
			$this->Flash->warning(__('Transition blocked by: {0}', $blockedBy ?: 'guard'));
		} else {
			$this->Flash->error(__('Transition failed: {0}', $result->getError()?->getMessage() ?? 'Unknown error'));
		}

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
