<?php
declare(strict_types=1);

namespace Sandbox\Controller;

use Sandbox\Model\Table\SandboxArticlesTable;

/**
 * BouncerExamples Controller
 *
 * Demonstrates the Bouncer plugin approval workflow functionality.
 * Shows how user-submitted content can be moderated before publication.
 *
 * @property SandboxArticlesTable $SandboxArticles
 */
class BouncerExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->setHelpers(['Tools.Format', 'Tools.Time']);

		// Add Bouncer behavior to SandboxArticles for this controller only
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		if (!$sandboxArticlesTable->hasBehavior('Bouncer')) {
			$sandboxArticlesTable->addBehavior('Bouncer.Bouncer', [
				'userField' => 'user_id',
				'requireApproval' => ['add', 'edit'],
				'validateOnDraft' => true,
				'autoSupersede' => true,
			]);
		}
	}

	/**
	 * Overview page explaining the Bouncer plugin
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$this->set('title', 'Bouncer Plugin - Approval Workflow');
	}

	/**
	 * List all articles (both published and those with pending changes)
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function articles() {
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');

		$this->paginate = [
			'order' => ['SandboxArticles.created' => 'DESC'],
			'limit' => 20,
		];

		$articles = $this->paginate($sandboxArticlesTable);

		// Get pending drafts count for each article
		$bouncerTable = $this->fetchTable('Bouncer.BouncerRecords');
		$pendingCounts = [];
		foreach ($articles as $article) {
			$count = $bouncerTable->find()
				->where([
					'source' => 'SandboxArticles',
					'primary_key' => $article->id,
					'status' => 'pending',
				])
				->count();
			$pendingCounts[$article->id] = $count;
		}

		// Get pending new articles count
		$pendingNewCount = $bouncerTable->find()
			->where([
				'source' => 'SandboxArticles',
				'primary_key IS' => null,
				'status' => 'pending',
			])
			->count();

		$this->set(compact('articles', 'pendingCounts', 'pendingNewCount'));
	}

	/**
	 * Add a new article (will be sent for approval)
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function add() {
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$article = $sandboxArticlesTable->newEmptyEntity();

		if ($this->request->is('post')) {
			$data = $this->request->getData();
			// Simulate a logged-in user (in real app, get from Authentication)
			$userId = $data['user_id'] ?? 1;

			$article = $sandboxArticlesTable->patchEntity($article, $data);

			// Pass user ID to bouncer
			if ($sandboxArticlesTable->save($article, ['bouncerUserId' => $userId])) {
				if ($sandboxArticlesTable->getBehavior('Bouncer')->wasBounced()) {
					$this->Flash->success('Your article has been submitted and is pending approval.');

					return $this->redirect(['action' => 'articles']);
				}

				$this->Flash->success('Article saved directly (bouncer bypassed).');

				return $this->redirect(['action' => 'articles']);
			}

			if ($article->getErrors()) {
				$this->Flash->error('Please fix the validation errors below.');
			} else {
				$this->Flash->error('Could not save the article. Please try again.');
			}
		}

		$this->set(compact('article'));
	}

	/**
	 * Edit an existing article (changes will be sent for approval)
	 *
	 * @param string|null $id Article id.
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit($id = null) {
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$article = $sandboxArticlesTable->get($id);

		// Check for existing draft
		$userId = $this->request->getQuery('user_id', 1); // Simulate logged-in user
		$bouncerBehavior = $sandboxArticlesTable->getBehavior('Bouncer');
		$draft = $bouncerBehavior->loadDraft($id, $userId);

		if ($draft) {
			// Overlay draft data onto the article
			$article = $sandboxArticlesTable->patchEntity($article, $draft->get('data'));
			$this->Flash->info('You are editing your pending draft.');
		}

		if ($this->request->is(['patch', 'post', 'put'])) {
			$data = $this->request->getData();
			$userId = $data['user_id'] ?? 1;

			$article = $sandboxArticlesTable->patchEntity($article, $data);

			if ($sandboxArticlesTable->save($article, ['bouncerUserId' => $userId])) {
				if ($bouncerBehavior->wasBounced()) {
					$this->Flash->success('Your changes are pending approval.');

					return $this->redirect(['action' => 'articles']);
				}

				$this->Flash->success('Article updated directly (bouncer bypassed).');

				return $this->redirect(['action' => 'articles']);
			}

			$this->Flash->error('Could not update the article. Please try again.');
		}

		$this->set(compact('article'));
	}

	/**
	 * View a single article
	 *
	 * @param string|null $id Article id.
	 * @return \Cake\Http\Response|null|void
	 */
	public function view($id = null) {
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$article = $sandboxArticlesTable->get($id);

		$this->set(compact('article'));
	}

	/**
	 * Admin interface: View all pending changes
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function pending() {
		$bouncerTable = $this->fetchTable('Bouncer.BouncerRecords');

		$query = $bouncerTable->find()
			->where([
				'source' => 'SandboxArticles',
				'status' => 'pending',
			])
			->orderBy(['BouncerRecords.created' => 'DESC']);

		$this->paginate = [
			'limit' => 20,
		];

		$pendingRecords = $this->paginate($query);

		$this->set(compact('pendingRecords'));
	}

	/**
	 * Admin interface: Review a pending change (diff view)
	 *
	 * @param string|null $id Bouncer record id.
	 * @return \Cake\Http\Response|null|void
	 */
	public function review($id = null) {
		$bouncerTable = $this->fetchTable('Bouncer.BouncerRecords');
		$bouncerRecord = $bouncerTable->get($id);

		if ($bouncerRecord->status !== 'pending') {
			$this->Flash->warning('This change has already been ' . $bouncerRecord->status . '.');

			return $this->redirect(['action' => 'pending']);
		}

		$this->set(compact('bouncerRecord'));
	}

	/**
	 * Admin interface: Approve a pending change
	 *
	 * @param string|null $id Bouncer record id.
	 * @return \Cake\Http\Response
	 */
	public function approve($id = null) {
		$this->request->allowMethod(['post']);

		$bouncerTable = $this->fetchTable('Bouncer.BouncerRecords');
		$bouncerRecord = $bouncerTable->get($id);

		if ($bouncerRecord->status !== 'pending') {
			$this->Flash->warning('This change has already been processed.');

			return $this->redirect(['action' => 'pending']);
		}

		// Apply the approved changes
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$bouncerBehavior = $sandboxArticlesTable->getBehavior('Bouncer');

		$entity = $bouncerBehavior->applyApprovedChanges($bouncerRecord);

		if ($entity) {
			// Mark as approved
			$reviewerId = $this->request->getData('reviewer_id', 1); // Simulate admin user
			$bouncerRecord = $bouncerTable->patchEntity($bouncerRecord, [
				'status' => 'approved',
				'reviewer_id' => $reviewerId,
				'reviewed' => new \DateTime(),
				'reason' => $this->request->getData('reason'),
			]);

			if ($bouncerTable->save($bouncerRecord)) {
				$this->Flash->success('Changes approved and published successfully.');

				return $this->redirect(['action' => 'pending']);
			}

			$this->Flash->error('Could not save approval status.');
		} else {
			$this->Flash->error('Could not apply changes. Validation may have failed.');
		}

		return $this->redirect(['action' => 'review', $id]);
	}

	/**
	 * Admin interface: Reject a pending change
	 *
	 * @param string|null $id Bouncer record id.
	 * @return \Cake\Http\Response
	 */
	public function reject($id = null) {
		$this->request->allowMethod(['post']);

		$bouncerTable = $this->fetchTable('Bouncer.BouncerRecords');
		$bouncerRecord = $bouncerTable->get($id);

		if ($bouncerRecord->status !== 'pending') {
			$this->Flash->warning('This change has already been processed.');

			return $this->redirect(['action' => 'pending']);
		}

		$reviewerId = $this->request->getData('reviewer_id', 1); // Simulate admin user
		$bouncerRecord = $bouncerTable->patchEntity($bouncerRecord, [
			'status' => 'rejected',
			'reviewer_id' => $reviewerId,
			'reviewed' => new \DateTime(),
			'reason' => $this->request->getData('reason', 'Rejected by moderator'),
		]);

		if ($bouncerTable->save($bouncerRecord)) {
			$this->Flash->success('Changes rejected.');

			return $this->redirect(['action' => 'pending']);
		}

		$this->Flash->error('Could not save rejection status.');

		return $this->redirect(['action' => 'review', $id]);
	}

	/**
	 * Demo: Show article creation with bouncer bypass (admin action)
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function adminAdd() {
		$sandboxArticlesTable = $this->fetchTable('Sandbox.SandboxArticles');
		$article = $sandboxArticlesTable->newEmptyEntity();

		if ($this->request->is('post')) {
			$article = $sandboxArticlesTable->patchEntity($article, $this->request->getData());

			// Admin bypasses bouncer
			if ($sandboxArticlesTable->save($article, ['bypassBouncer' => true])) {
				$this->Flash->success('Article published directly (admin bypass).');

				return $this->redirect(['action' => 'articles']);
			}

			$this->Flash->error('Could not save the article.');
		}

		$this->set(compact('article'));
	}

}
