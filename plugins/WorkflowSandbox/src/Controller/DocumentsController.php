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
	 * With autoSave and autoLog enabled on the behavior, this is all we need:
	 * - applyTransition() runs workflow commands (clearApprovalState for revise)
	 * - autoSave saves the entity
	 * - autoLog logs the transition
	 *
	 * Note: Approval/rejection tracking requires form data (user_id, reason),
	 * so we set those before the transition runs.
	 *
	 * @param int $id Document ID
	 * @return \Cake\Http\Response|null
	 */
	public function transition(int $id): ?Response {
		$this->request->allowMethod(['post']);

		$document = $this->Documents->get($id);
		$transitionName = $this->request->getData('transition');

		// Handle form data that needs to be set before transition
		$approverId = (int)($this->request->getData('approver_id') ?: 1);

		if (str_starts_with($transitionName, 'approve_level')) {
			$document->addApprover($approverId);
			$document->current_approver_level = (int)substr($transitionName, -1);
		} elseif ($transitionName === 'reject') {
			$document->rejected_by = $approverId;
			$document->rejection_reason = $this->request->getData('rejection_reason');
		}
		// Note: 'revise' is handled by clearApprovalState command

		$result = $this->Documents->applyTransition($document, $transitionName, [
			'reason' => $this->request->getData('reason') ?: 'Manual transition',
			'user_id' => $approverId,
		]);

		if ($result->isSuccess()) {
			$this->Flash->success(__('Transition "{0}" applied successfully.', $transitionName));
		} elseif ($result->isBlocked()) {
			$this->Flash->warning(__('Transition blocked: {0}', implode(', ', $result->getBlockedBy())));
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
