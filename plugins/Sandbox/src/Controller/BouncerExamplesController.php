<?php
declare(strict_types=1);

namespace Sandbox\Controller;

use Cake\Cache\Cache;
use DateTime;

/**
 * BouncerExamples Controller
 *
 * Demonstrates the Bouncer plugin approval workflow functionality.
 * Shows how user-submitted content can be moderated before publication.
 *
 * @property \Sandbox\Model\Table\SandboxArticlesTable $SandboxArticles
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxArticle> paginate(\Cake\Datasource\RepositoryInterface|\Cake\Datasource\QueryInterface|string|null $object = null, array $settings = [])
 */
class BouncerExamplesController extends SandboxAppController {

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Sandbox.SandboxArticles';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->setHelpers(['Tools.Format', 'Tools.Time']);

		// Add Bouncer behavior to SandboxArticles for this controller only
		if (!$this->SandboxArticles->hasBehavior('Bouncer')) {
			$this->SandboxArticles->addBehavior('Bouncer.Bouncer', [
				'userField' => 'user_id',
				'requireApproval' => ['add', 'edit', 'delete'],
				'validateOnDraft' => true,
				'autoSupersede' => true,
			]);
		}

		// Ensure demo data is available and fresh
		$this->ensureDemoData();
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
		$this->paginate = [
			'order' => ['SandboxArticles.created' => 'DESC'],
			'limit' => 20,
		];

		$articles = $this->paginate($this->SandboxArticles);

		// Get pending drafts count for each article
		$bouncerTable = $this->fetchTable('Bouncer.BouncerRecords');
		$pendingCounts = [];
		foreach ($articles as $article) {
			/** @var \Sandbox\Model\Entity\SandboxArticle $article */
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
		$article = $this->SandboxArticles->newEmptyEntity();

		if ($this->request->is('post')) {
			$article = $this->SandboxArticles->patchEntity($article, $this->request->getData());
			$userId = $this->request->getData('user_id', 1);

			$this->SandboxArticles->save($article, ['bouncerUserId' => $userId]);
			/** @var \Bouncer\Model\Behavior\BouncerBehavior $bouncerBehavior */
			/** @phpstan-ignore varTag.type, argument.type, argument.templateType */
			$bouncerBehavior = $this->SandboxArticles->getBehavior('Bouncer');

			// Check if it was bounced (intercepted for approval)
			if ($bouncerBehavior->wasBounced()) {
				$this->Flash->success('Your article has been submitted and is pending approval.');

				return $this->redirect(['action' => 'articles']);
			}

			if (!$article->getErrors()) {
				$this->Flash->success('Article saved successfully.');

				return $this->redirect(['action' => 'articles']);
			}

			$this->Flash->error('Please fix the validation errors below.');
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
		$article = $this->SandboxArticles->get($id);
		/** @phpstan-var \Bouncer\Model\Behavior\BouncerBehavior $bouncerBehavior */
		/** @phpstan-ignore varTag.type, argument.type, argument.templateType */
		$bouncerBehavior = $this->SandboxArticles->getBehavior('Bouncer');

		// Check for existing draft and overlay it
		$userId = (int)$this->request->getQuery('user_id', 1); // Simulate logged-in user
		if ($bouncerBehavior->withDraft($article, $userId)) {
			$this->Flash->info('You are editing your pending draft.');
		}

		if ($this->request->is(['patch', 'post', 'put'])) {
			$article = $this->SandboxArticles->patchEntity($article, $this->request->getData());
			$userId = $this->request->getData('user_id', 1);

			$result = $this->SandboxArticles->save($article, ['bouncerUserId' => $userId]);

			// Check if it was bounced (intercepted for approval)
			if ($bouncerBehavior->wasBounced()) {
				$this->Flash->success('Your changes are pending approval.');

				return $this->redirect(['action' => 'view', $id]);
			}

			if (!$article->getErrors() && $result) {
				$this->Flash->success('Article updated successfully.');

				return $this->redirect(['action' => 'articles']);
			}

			$this->Flash->error('Please fix the validation errors below.');
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
		$article = $this->SandboxArticles->get($id);
		/** @phpstan-var \Bouncer\Model\Behavior\BouncerBehavior $bouncerBehavior */
		/** @phpstan-ignore varTag.type, argument.type, argument.templateType */
		$bouncerBehavior = $this->SandboxArticles->getBehavior('Bouncer');

		// Check for existing draft and overlay it
		$userId = (int)$this->request->getQuery('user_id', 1); // Simulate logged-in user
		$hasDraft = $bouncerBehavior->withDraft($article, $userId);

		$this->set(compact('article', 'hasDraft'));
	}

	/**
	 * Delete an article (will be sent for approval)
	 *
	 * @param string|null $id Article id.
	 * @return \Cake\Http\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);

		$article = $this->SandboxArticles->get($id);

		// Simulate logged-in user - in real app, get from Auth
		$userId = 1;

		$result = $this->SandboxArticles->delete($article, ['bouncerUserId' => $userId]);
		/** @phpstan-var \Bouncer\Model\Behavior\BouncerBehavior $bouncerBehavior */
		/** @phpstan-ignore varTag.type, argument.type, argument.templateType */
		$bouncerBehavior = $this->SandboxArticles->getBehavior('Bouncer');

		// Check if it was bounced (intercepted for approval)
		if ($bouncerBehavior->wasBounced()) {
			$this->Flash->success('Your deletion request is pending approval.');

			return $this->redirect(['action' => 'articles']);
		}

		if ($result) {
			$this->Flash->success('Article deleted successfully.');

			return $this->redirect(['action' => 'articles']);
		}

		$this->Flash->error('Could not delete the article. Please try again.');

		return $this->redirect(['action' => 'articles']);
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
		/** @var \Bouncer\Model\Entity\BouncerRecord $bouncerRecord */
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
	 * @return \Cake\Http\Response|null
	 */
	public function approve($id = null) {
		$this->request->allowMethod(['post']);

		$bouncerTable = $this->fetchTable('Bouncer.BouncerRecords');
		/** @var \Bouncer\Model\Entity\BouncerRecord $bouncerRecord */
		$bouncerRecord = $bouncerTable->get($id);

		if ($bouncerRecord->status !== 'pending') {
			$this->Flash->warning('This change has already been processed.');

			return $this->redirect(['action' => 'pending']);
		}

		// Mark as approved first
		$reviewerId = $this->request->getData('reviewer_id', 1); // Simulate admin user
		$bouncerRecord = $bouncerTable->patchEntity($bouncerRecord, [
			'status' => 'approved',
			'reviewer_id' => $reviewerId,
			'reviewed' => new DateTime(),
			'reason' => $this->request->getData('reason'),
		]);

		if (!$bouncerTable->save($bouncerRecord)) {
			$this->Flash->error('Could not save approval status.');

			return $this->redirect(['action' => 'review', $id]);
		}

		// Apply the approved changes
		/** @phpstan-var \Bouncer\Model\Behavior\BouncerBehavior $bouncerBehavior */
		/** @phpstan-ignore varTag.type, argument.type, argument.templateType */
		$bouncerBehavior = $this->SandboxArticles->getBehavior('Bouncer');

		// Reload the record to get updated data
		/** @var \Bouncer\Model\Entity\BouncerRecord $bouncerRecord */
		$bouncerRecord = $bouncerTable->get($id);
		$entity = $bouncerBehavior->applyApprovedChanges($bouncerRecord);

		if ($entity) {
			$this->Flash->success('Changes approved and published successfully.');
		} else {
			$this->Flash->warning('Changes approved but could not be published. Please check validation.');
		}

		return $this->redirect(['action' => 'pending']);
	}

	/**
	 * Admin interface: Reject a pending change
	 *
	 * @param string|null $id Bouncer record id.
	 * @return \Cake\Http\Response|null
	 */
	public function reject($id = null) {
		$this->request->allowMethod(['post']);

		$bouncerTable = $this->fetchTable('Bouncer.BouncerRecords');
		/** @var \Bouncer\Model\Entity\BouncerRecord $bouncerRecord */
		$bouncerRecord = $bouncerTable->get($id);

		if ($bouncerRecord->status !== 'pending') {
			$this->Flash->warning('This change has already been processed.');

			return $this->redirect(['action' => 'pending']);
		}

		$reviewerId = $this->request->getData('reviewer_id', 1); // Simulate admin user
		$bouncerRecord = $bouncerTable->patchEntity($bouncerRecord, [
			'status' => 'rejected',
			'reviewer_id' => $reviewerId,
			'reviewed' => new DateTime(),
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
		$article = $this->SandboxArticles->newEmptyEntity();

		if ($this->request->is('post')) {
			$article = $this->SandboxArticles->patchEntity($article, $this->request->getData());

			// Admin bypasses bouncer
			if ($this->SandboxArticles->save($article, ['bypassBouncer' => true])) {
				$this->Flash->success('Article published directly (admin bypass).');

				return $this->redirect(['action' => 'articles']);
			}

			$this->Flash->error('Could not save the article.');
		}

		$this->set(compact('article'));
	}

	/**
	 * Ensure demo data exists and reset every 6 hours
	 *
	 * @return void
	 */
	protected function ensureDemoData(): void {
		if (PHP_SAPI === 'cli') {
			return;
		}

		$cacheKey = 'bouncer_demo_last_reset';
		$cache = Cache::read($cacheKey);
		$now = time();
		$sixHours = 6 * 3600;

		// Check if we need to reset (no cache or older than 6 hours)
		if ($this->request->getQuery('force-update') || $cache === null || ($now - $cache) >= $sixHours) {
			$this->resetDemoData();
			Cache::write($cacheKey, $now);

			return;
		}

		// Check if we have at least 3 articles
		$count = $this->SandboxArticles->find()->count();
		if ($count < 3) {
			$this->resetDemoData();
			Cache::write($cacheKey, $now);
		}
	}

	/**
	 * Reset demo data - truncate and create fresh demo records
	 *
	 * @return void
	 */
	protected function resetDemoData(): void {
		$bouncerRecordsTable = $this->fetchTable('Bouncer.BouncerRecords');

		// Truncate both tables
		$connection = $this->SandboxArticles->getConnection();
		$connection->execute('TRUNCATE TABLE sandbox_articles');
		$bouncerRecordsTable->deleteAll('1=1');

		// Create 3 demo articles
		$demoArticles = [
			[
				'title' => 'Getting Started with Bouncer',
				'content' => 'The Bouncer plugin provides a flexible approval workflow for CakePHP applications. This demo shows how user submissions can be moderated before publication.',
				'status' => 'draft',
				'user_id' => 1,
			],
			[
				'title' => 'Understanding the Approval Process',
				'content' => 'When a user submits changes, they are stored as pending drafts in the bouncer_records table. Admins can review, approve, or reject these changes through a dedicated interface.',
				'status' => 'draft',
				'user_id' => 1,
			],
			[
				'title' => 'Advanced Features',
				'content' => 'Bouncer supports draft auto-superseding, validation on draft creation, and the ability to bypass approval for trusted users or admins.',
				'status' => 'published',
				'user_id' => 1,
			],
		];

		foreach ($demoArticles as $data) {
			$article = $this->SandboxArticles->newEntity($data);
			$this->SandboxArticles->save($article, ['bypassBouncer' => true]);
		}
	}

}
