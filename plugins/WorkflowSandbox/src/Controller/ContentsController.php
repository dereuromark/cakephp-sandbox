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
	 * @param int|null $id Content ID
	 * @return \Cake\Http\Response|null
	 */
	public function transition(?int $id = null): ?Response {
		$this->request->allowMethod(['post']);

		$content = $this->Contents->get($id);
		$transition = $this->request->getData('transition');

		if (!$transition) {
			$this->Flash->error(__('No transition specified.'));

			return $this->redirect(['action' => 'view', $id]);
		}

		// Handle special transitions that need extra data
		if ($transition === 'assign_reviewer') {
			$reviewerId = $this->request->getData('reviewer_id');
			if ($reviewerId) {
				$content->reviewer_id = $reviewerId;
			}
		} elseif ($transition === 'reject') {
			$reason = $this->request->getData('rejection_reason');
			if ($reason) {
				$content->rejection_reason = $reason;
			}
		}

		$result = $this->Contents->applyTransition($content, $transition);

		if ($result->isSuccess()) {
			if ($transition === 'publish') {
				$content->published_at = new DateTime();
			} elseif ($transition === 'revise') {
				$content->rejection_reason = null;
			}

			$this->Contents->save($content);

			// Log the transition
			$logger = new TransitionLogger();
			$logger->log('content', 'WorkflowSandbox.Contents', $content, $result, $transition);

			$this->Flash->success(__('Transition "{0}" applied. New status: {1}', $transition, $content->status));
		} elseif ($result->isBlocked()) {
			$blockedBy = implode(', ', $result->getBlockedBy());
			$this->Flash->warning(__('Transition blocked by: {0}', $blockedBy ?: 'guard'));
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
