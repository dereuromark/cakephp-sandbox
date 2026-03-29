<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Response;
use Workflow\Service\TransitionLogger;
use Workflow\Service\WorkflowRegistry;

/**
 * Documents Controller
 *
 * Demo for Document approval workflow.
 *
 * @property \WorkflowSandbox\Model\Table\DocumentsTable $Documents
 */
class DocumentsController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->Documents = $this->fetchTable('WorkflowSandbox.Documents');
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
	 * Index - List documents and show workflow diagram.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index(): ?Response {
		$documents = $this->Documents->find()
			->contain(['Users', 'Rejectors'])
			->orderByDesc('Documents.created')
			->limit(20)
			->all()
			->toArray();

		$definition = $this->getRegistry()->getWorkflow('document');
		$users = $this->fetchTable('Users')->find('list')->toArray();

		$this->set(compact('documents', 'definition', 'users'));

		return null;
	}

	/**
	 * Create a new document.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function add(): ?Response {
		$document = $this->Documents->newEmptyEntity();

		if ($this->request->is('post')) {
			$document = $this->Documents->patchEntity($document, $this->request->getData());
			$document->status = 'draft';
			$document->current_approver_level = 0;

			if ($this->Documents->save($document)) {
				$this->Flash->success(__('Document created as draft.'));

				return $this->redirect(['action' => 'view', $document->id]);
			}
			$this->Flash->error(__('Could not create document.'));
		}

		$users = $this->fetchTable('Users')->find('list')->toArray();
		$this->set(compact('document', 'users'));

		return null;
	}

	/**
	 * View a document.
	 *
	 * @param int|null $id Document ID
	 * @return \Cake\Http\Response|null
	 */
	public function view(?int $id = null): ?Response {
		$document = $this->Documents->get($id, contain: ['Users', 'Rejectors']);
		$definition = $this->getRegistry()->getWorkflow('document');
		$availableTransitions = $this->Documents->getAvailableTransitions($document);

		// Get transition history
		$logger = new TransitionLogger();
		$transitionHistory = $logger->getHistory('document', 'WorkflowSandbox.Documents', (string)$document->id);

		$this->set(compact('document', 'definition', 'availableTransitions', 'transitionHistory'));

		return null;
	}

	/**
	 * Apply a transition to a document.
	 *
	 * @param int|null $id Document ID
	 * @return \Cake\Http\Response|null
	 */
	public function transition(?int $id = null): ?Response {
		$this->request->allowMethod(['post']);

		$document = $this->Documents->get($id);
		$transition = $this->request->getData('transition');

		if (!$transition) {
			$this->Flash->error(__('No transition specified.'));

			return $this->redirect(['action' => 'view', $id]);
		}

		// Get current user ID (for demo, we'll use a fixed ID or first user)
		$currentUserId = $this->request->getData('approver_id') ?: 1;

		$result = $this->Documents->applyTransition($document, $transition);

		if ($result->isSuccess()) {
			// Handle approval level tracking
			if (str_starts_with($transition, 'approve_level')) {
				$document->addApprover((int)$currentUserId);
				$level = (int)substr($transition, -1);
				$document->current_approver_level = $level;
			} elseif ($transition === 'reject') {
				$document->rejected_by = (int)$currentUserId;
				$document->rejection_reason = $this->request->getData('rejection_reason');
			} elseif ($transition === 'revise') {
				$document->rejected_by = null;
				$document->rejection_reason = null;
				$document->approved_by = null;
				$document->current_approver_level = 0;
			}

			$this->Documents->save($document);

			// Log the transition
			$logger = new TransitionLogger();
			$logger->log('document', 'WorkflowSandbox.Documents', $document, $result, $transition);

			$this->Flash->success(__('Transition "{0}" applied. New status: {1}', $transition, $document->status));
		} elseif ($result->isBlocked()) {
			$blockedBy = implode(', ', $result->getBlockedBy());
			$this->Flash->warning(__('Transition blocked by: {0}', $blockedBy ?: 'guard'));
		} else {
			$this->Flash->error(__('Transition failed: {0}', $result->getError()?->getMessage() ?? 'Unknown error'));
		}

		return $this->redirect(['action' => 'view', $id]);
	}

	/**
	 * Delete a document.
	 *
	 * @param int|null $id Document ID
	 * @return \Cake\Http\Response|null
	 */
	public function delete(?int $id = null): ?Response {
		$this->request->allowMethod(['post', 'delete']);

		$document = $this->Documents->get($id);

		if ($this->Documents->delete($document)) {
			$this->Flash->success(__('Document deleted.'));
		} else {
			$this->Flash->error(__('Could not delete document.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Reset all documents (for demo purposes).
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function reset(): ?Response {
		$this->request->allowMethod(['post']);

		$this->Documents->deleteAll([]);
		$this->Flash->success(__('All documents reset.'));

		return $this->redirect(['action' => 'index']);
	}

}
