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
		$this->enableRetainFlashMessages();

		// First create a draft by editing
		$this->post(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'edit', 1], [
			'title' => 'Updated Title',
			'content' => 'Updated content',
			'status' => 'published',
			'user_id' => 1,
		]);

		// Should redirect to view page after creating draft
		$this->assertResponseCode(302);
		$this->assertFlashMessage('Your changes are pending approval.');
		$this->assertRedirectContains('/bouncer-examples/view/1');

		// Find the bouncer record that was created
		$bouncerTable = $this->getTableLocator()->get('Bouncer.BouncerRecords');
		$bouncerRecord = $bouncerTable->find()
			->where([
				'source' => 'SandboxArticles',
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
