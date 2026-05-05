<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Sandbox\Test\Factory\SandboxArticleFactory;
use Shim\TestSuite\IntegrationTestCase;

/**
 * Sandbox\Controller\BouncerExamplesController Test Case
 *
 * @uses \Sandbox\Controller\BouncerExamplesController
 */
class BouncerExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var \Sandbox\Model\Entity\SandboxArticle
	 */
	protected $article;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		$this->disableErrorHandlerMiddleware();

		$this->article = SandboxArticleFactory::make()->persist();
	}

	/**
	 * Test that the index action is routable and doesn't throw errors
	 *
	 * @return void
	 */
	public function testIndexIsRoutable() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'index']);
		$responseCode = $this->_response->getStatusCode();
		$this->assertTrue(
			$responseCode >= 200 && $responseCode < 400,
			"Index action returned unexpected status code: {$responseCode}",
		);
	}

	/**
	 * Test add GET displays form
	 *
	 * @return void
	 */
	public function testAddGet() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'add']);

		$this->assertResponseOk();
		$this->assertResponseContains('Submit New Article');
		$this->assertResponseContains('form');
	}

	/**
	 * Test adminAdd GET displays form
	 *
	 * @return void
	 */
	public function testAdminAddGet() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'adminAdd']);

		$this->assertResponseOk();
		$this->assertResponseContains('Admin Direct Publish');
		$this->assertResponseContains('Admin Bypass');
		$this->assertResponseContains('form');
	}

	/**
	 * Test view action displays article
	 *
	 * @return void
	 */
	public function testView() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'view', $this->article->id]);

		$this->assertResponseOk();
		$this->assertResponseContains($this->article->title);
	}

	/**
	 * Test edit GET displays form
	 *
	 * @return void
	 */
	public function testEditGet() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', $this->article->id]);

		$this->assertResponseOk();
		$this->assertResponseContains('Edit Article');
		$this->assertResponseContains('Approval Required');
		$this->assertResponseContains('form');
	}

	/**
	 * Test add POST creates draft and redirects to review
	 *
	 * @return void
	 */
	public function testAddPostCreatesDraft() {
		$this->enableRetainFlashMessages();
		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'add'], [
			'title' => 'Test Draft Article',
			'content' => 'This is a test article for approval',
			'status' => 'draft',
			'user_id' => 1,
		]);

		$this->assertResponseCode(302);
		$this->assertFlashMessage('Your article has been submitted and is pending approval.');
		$this->assertRedirectContains('/articles');
	}

	/**
	 * Test edit POST creates draft and redirects to review
	 *
	 * @return void
	 */
	public function testEditPostCreatesDraft() {
		$this->enableRetainFlashMessages();
		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', $this->article->id], [
			'title' => 'Updated Title',
			'content' => 'Updated content',
			'status' => 'published',
			'user_id' => 1,
		]);

		$this->assertResponseCode(302);
		$this->assertFlashMessage('Your changes are pending approval.');
		$this->assertRedirectContains('/bouncer-examples/view/' . $this->article->id);
	}

	/**
	 * Test review page shows original data for edits
	 *
	 * @return void
	 */
	public function testReviewShowsOriginalData() {
		$sandboxArticlesTable = $this->getTableLocator()->get('Sandbox.SandboxArticles');
		$sandboxArticlesTable->addBehavior('Bouncer.Bouncer', [
			'userField' => 'user_id',
			'requireApproval' => ['add', 'edit', 'delete'],
			'validateOnDraft' => true,
			'autoSupersede' => true,
		]);

		$article = $sandboxArticlesTable->get($this->article->id);
		$article = $sandboxArticlesTable->patchEntity($article, [
			'title' => 'Updated Title',
			'content' => 'Updated content',
			'status' => 'published',
			'user_id' => 1,
		]);
		$sandboxArticlesTable->save($article, ['bouncerUserId' => 1]);

		$bouncerTable = $this->getTableLocator()->get('Bouncer.BouncerRecords');
		$bouncerRecord = $bouncerTable->find()
			->where([
				'source' => 'Sandbox.SandboxArticles',
				'primary_key' => $this->article->id,
				'status' => 'pending',
			])
			->orderBy(['BouncerRecords.created' => 'DESC'])
			->first();

		$this->assertNotNull($bouncerRecord, 'Should have created a bouncer record');

		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'review', $bouncerRecord->id]);

		$this->assertResponseOk();
		$this->assertResponseContains('Original');
		$this->assertResponseContains('Proposed');
		$this->assertResponseContains($this->article->title);
		$this->assertResponseContains('Updated Title');
	}

	/**
	 * Test reverting edit back to original removes pending draft
	 *
	 * @return void
	 */
	public function testRevertEditRemovesPendingDraft() {
		$this->enableRetainFlashMessages();

		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', $this->article->id], [
			'title' => 'Changed Title',
			'content' => 'Changed content',
			'status' => 'published',
			'user_id' => 1,
		]);

		$this->assertResponseCode(302);
		$this->assertFlashMessage('Your changes are pending approval.');

		$bouncerTable = $this->getTableLocator()->get('Bouncer.BouncerRecords');
		$pendingCount = $bouncerTable->find()
			->where([
				'source' => 'Sandbox.SandboxArticles',
				'primary_key' => $this->article->id,
				'status' => 'pending',
			])
			->count();
		$this->assertEquals(1, $pendingCount, 'Should have 1 pending draft after edit');
	}

	/**
	 * Test reverting edit back to original removes pending draft - part 2
	 *
	 * @return void
	 */
	public function testRevertEditRemovesPendingDraftPart2() {
		$this->enableRetainFlashMessages();

		$sandboxArticlesTable = $this->getTableLocator()->get('Sandbox.SandboxArticles');
		$sandboxArticlesTable->addBehavior('Bouncer.Bouncer', [
			'userField' => 'user_id',
			'requireApproval' => ['add', 'edit', 'delete'],
			'validateOnDraft' => true,
			'autoSupersede' => true,
		]);

		$article = $sandboxArticlesTable->get($this->article->id);
		$article = $sandboxArticlesTable->patchEntity($article, [
			'title' => 'Changed Title',
			'content' => 'Changed content',
			'status' => 'published',
			'user_id' => 1,
		]);
		$sandboxArticlesTable->save($article, ['bouncerUserId' => 1]);

		$bouncerTable = $this->getTableLocator()->get('Bouncer.BouncerRecords');
		$pendingCount = $bouncerTable->find()
			->where([
				'source' => 'Sandbox.SandboxArticles',
				'primary_key' => $this->article->id,
				'status' => 'pending',
			])
			->count();
		$this->assertEquals(1, $pendingCount, 'Should have 1 pending draft before revert');

		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', $this->article->id], [
			'title' => $this->article->title,
			'content' => $this->article->content,
			'status' => $this->article->status,
			'user_id' => 1,
		]);

		$this->assertResponseCode(302);
		$this->assertRedirectContains('/bouncer-examples/articles');
		$this->assertFlashMessage('Article updated successfully.');

		$pendingCount = $bouncerTable->find()
			->where([
				'source' => 'Sandbox.SandboxArticles',
				'primary_key' => $this->article->id,
				'status' => 'pending',
			])
			->count();
		$this->assertEquals(0, $pendingCount, 'Pending draft should be removed when reverted to original');
	}

	/**
	 * Test delete POST creates deletion request
	 *
	 * @return void
	 */
	public function testDeletePostCreatesDeletionRequest() {
		$this->enableRetainFlashMessages();
		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'delete', $this->article->id]);

		$this->assertResponseCode(302);
		$this->assertFlashMessage('Your deletion request is pending approval.');
		$this->assertRedirect(['action' => 'articles']);
	}

}
