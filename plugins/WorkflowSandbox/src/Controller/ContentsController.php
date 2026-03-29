<?php
declare(strict_types=1);

namespace WorkflowSandbox\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Response;
use Workflow\Service\TransitionLogger;
use Workflow\Service\WorkflowRegistry;

/**
 * Contents Controller
 *
 * Demo for Content moderation workflow.
 *
 * @property \WorkflowSandbox\Model\Table\ContentsTable $Contents
 */
class ContentsController extends AppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->Contents = $this->fetchTable('WorkflowSandbox.Contents');
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
	 * Index - List contents and show workflow diagram.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function index(): ?Response {
		$contents = $this->Contents->find()
			->contain(['Users', 'Reviewers'])
			->orderByDesc('Contents.created')
			->limit(20)
			->all()
			->toArray();

		$definition = $this->getRegistry()->getWorkflow('content');
		$users = $this->fetchTable('Users')->find('list')->toArray();

		$this->set(compact('contents', 'definition', 'users'));

		return null;
	}

	/**
	 * Create new content.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function add(): ?Response {
		$content = $this->Contents->newEmptyEntity();

		if ($this->request->is('post')) {
			$content = $this->Contents->patchEntity($content, $this->request->getData());
			$content->status = 'draft';

			if ($this->Contents->save($content)) {
				$this->Flash->success(__('Content created as draft.'));

				return $this->redirect(['action' => 'view', $content->id]);
			}
			$this->Flash->error(__('Could not create content.'));
		}

		$users = $this->fetchTable('Users')->find('list')->toArray();
		$this->set(compact('content', 'users'));

		return null;
	}

	/**
	 * View content.
	 *
	 * @param int|null $id Content ID
	 * @return \Cake\Http\Response|null
	 */
	public function view(?int $id = null): ?Response {
		$content = $this->Contents->get($id, contain: ['Users', 'Reviewers']);
		$definition = $this->getRegistry()->getWorkflow('content');
		$availableTransitions = $this->Contents->getAvailableTransitions($content);
		$users = $this->fetchTable('Users')->find('list')->toArray();

		// Get transition history
		$logger = new TransitionLogger();
		$transitionHistory = $logger->getHistory('content', 'WorkflowSandbox.Contents', (string)$content->id);

		$this->set(compact('content', 'definition', 'availableTransitions', 'users', 'transitionHistory'));

		return null;
	}

	/**
	 * Apply a transition to content.
	 *
	 * With autoSave and autoLog enabled on the behavior, this is all we need:
	 * - applyTransition() runs workflow commands (set timestamps, etc.)
	 * - autoSave saves the entity
	 * - autoLog logs the transition
	 *
	 * @param int $id Content ID
	 * @return \Cake\Http\Response|null
	 */
	public function transition(int $id): ?Response {
		$this->request->allowMethod(['post']);

		$content = $this->Contents->get($id);
		$transitionName = $this->request->getData('transition');

		// Handle special transitions that need form data before transition
		if ($transitionName === 'assign_reviewer' && $this->request->getData('reviewer_id')) {
			$content->reviewer_id = $this->request->getData('reviewer_id');
		} elseif ($transitionName === 'reject' && $this->request->getData('rejection_reason')) {
			$content->rejection_reason = $this->request->getData('rejection_reason');
		}

		$result = $this->Contents->applyTransition($content, $transitionName, [
			'reason' => $this->request->getData('reason') ?: 'Manual transition',
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
	 * Delete content.
	 *
	 * @param int|null $id Content ID
	 * @return \Cake\Http\Response|null
	 */
	public function delete(?int $id = null): ?Response {
		$this->request->allowMethod(['post', 'delete']);

		$content = $this->Contents->get($id);

		if ($this->Contents->delete($content)) {
			$this->Flash->success(__('Content deleted.'));
		} else {
			$this->Flash->error(__('Could not delete content.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Reset all contents (for demo purposes).
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function reset(): ?Response {
		$this->request->allowMethod(['post']);

		$this->Contents->deleteAll([]);
		$this->Flash->success(__('All contents reset.'));

		return $this->redirect(['action' => 'index']);
	}

}
