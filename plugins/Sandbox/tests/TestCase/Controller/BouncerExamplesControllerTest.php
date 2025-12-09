<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * Sandbox\Controller\BouncerExamplesController Test Case
 *
 * @uses \Sandbox\Controller\BouncerExamplesController
 */
class BouncerExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxArticles',
		'plugin.Sandbox.BouncerRecords',
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		$this->disableErrorHandlerMiddleware();
	}

	/**
	 * Test that the index action is routable and doesn't throw errors
	 *
	 * @return void
	 */
	public function testIndexIsRoutable() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'index']);
		// Just assert we got a valid HTTP response (not 404/500)
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
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'view', 1]);

		$this->assertResponseOk();
		$this->assertResponseContains('Lorem ipsum');
	}

	/**
	 * Test edit GET displays form
	 *
	 * @return void
	 */
	public function testEditGet() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', 1]);

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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', 1], [
			'title' => 'Updated Title',
			'content' => 'Updated content',
			'status' => 'published',
			'user_id' => 1,
		]);

		$this->assertResponseCode(302);
		$this->assertFlashMessage('Your changes are pending approval.');
		$this->assertRedirectContains('/bouncer-examples/view/1');
	}

	/**
	 * Test review page shows original data for edits
	 *
	 * @return void
	 */
	public function testReviewShowsOriginalData() {
		// First create a draft by editing
		$sandboxArticlesTable = $this->getTableLocator()->get('Sandbox.SandboxArticles');
		$sandboxArticlesTable->addBehavior('Bouncer.Bouncer', [
			'userField' => 'user_id',
			'requireApproval' => ['add', 'edit', 'delete'],
			'validateOnDraft' => true,
			'autoSupersede' => true,
		]);

		$article = $sandboxArticlesTable->get(1);
		$article = $sandboxArticlesTable->patchEntity($article, [
			'title' => 'Updated Title',
			'content' => 'Updated content',
			'status' => 'published',
			'user_id' => 1,
		]);
		$sandboxArticlesTable->save($article, ['bouncerUserId' => 1]);

		// Find the bouncer record that was created
		$bouncerTable = $this->getTableLocator()->get('Bouncer.BouncerRecords');
		$bouncerRecord = $bouncerTable->find()
			->where([
				'source' => 'Sandbox.SandboxArticles',
				'primary_key' => 1,
				'status' => 'pending',
			])
			->orderBy(['BouncerRecords.created' => 'DESC'])
			->first();

		$this->assertNotNull($bouncerRecord, 'Should have created a bouncer record');

		// Now visit the review page
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'review', $bouncerRecord->id]);

		$this->assertResponseOk();
		$this->assertResponseContains('Original'); // Should have "Original" column header
		$this->assertResponseContains('Proposed'); // Should have "Proposed" column header
		$this->assertResponseContains('Lorem ipsum'); // Original title from fixture
		$this->assertResponseContains('Updated Title'); // New title
	}

	/**
	 * Test reverting edit back to original removes pending draft
	 *
	 * @return void
	 */
	public function testRevertEditRemovesPendingDraft() {
		$this->enableRetainFlashMessages();

		// First create a draft by editing
		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', 1], [
			'title' => 'Changed Title',
			'content' => 'Changed content',
			'status' => 'published',
			'user_id' => 1,
		]);

		$this->assertResponseCode(302);
		$this->assertFlashMessage('Your changes are pending approval.');

		// Verify draft was created
		$bouncerTable = $this->getTableLocator()->get('Bouncer.BouncerRecords');
		$pendingCount = $bouncerTable->find()
			->where([
				'source' => 'Sandbox.SandboxArticles',
				'primary_key' => 1,
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

		// First create a draft using table layer (not a controller request)
		$sandboxArticlesTable = $this->getTableLocator()->get('Sandbox.SandboxArticles');
		$sandboxArticlesTable->addBehavior('Bouncer.Bouncer', [
			'userField' => 'user_id',
			'requireApproval' => ['add', 'edit', 'delete'],
			'validateOnDraft' => true,
			'autoSupersede' => true,
		]);

		$article = $sandboxArticlesTable->get(1);
		$article = $sandboxArticlesTable->patchEntity($article, [
			'title' => 'Changed Title',
			'content' => 'Changed content',
			'status' => 'published',
			'user_id' => 1,
		]);
		$sandboxArticlesTable->save($article, ['bouncerUserId' => 1]);

		// Verify draft was created
		$bouncerTable = $this->getTableLocator()->get('Bouncer.BouncerRecords');
		$pendingCount = $bouncerTable->find()
			->where([
				'source' => 'Sandbox.SandboxArticles',
				'primary_key' => 1,
				'status' => 'pending',
			])
			->count();
		$this->assertEquals(1, $pendingCount, 'Should have 1 pending draft before revert');

		// Now edit again via controller, reverting to original values from fixture
		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', 1], [
			'title' => 'Lorem ipsum dolor sit amet',
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'status' => 'Lorem ipsum dolor sit amet',
			'user_id' => 1,
		]);

		// Should redirect successfully without "pending approval" message
		// since the changes match the original (draft was removed and save proceeded)
		$this->assertResponseCode(302);
		$this->assertRedirectContains('/bouncer-examples/articles');
		$this->assertFlashMessage('Article updated successfully.');

		// Verify draft was removed
		$pendingCount = $bouncerTable->find()
			->where([
				'source' => 'Sandbox.SandboxArticles',
				'primary_key' => 1,
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
		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'delete', 1]);

		$this->assertResponseCode(302);
		$this->assertFlashMessage('Your deletion request is pending approval.');
		$this->assertRedirect(['action' => 'articles']);
	}

}
