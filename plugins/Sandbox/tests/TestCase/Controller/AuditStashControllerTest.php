<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use App\Test\Factory\AuditLogFactory;
use AuditStash\AuditLogType;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Sandbox\Test\Factory\SandboxArticleFactory;

/**
 * Sandbox\Controller\AuditStashController Test Case
 *
 * @uses \Sandbox\Controller\AuditStashController
 */
class AuditStashControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @return void
	 */
	public function testIndex(): void {
		SandboxArticleFactory::make()->persist();
		AuditLogFactory::make()->persist();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAddPost(): void {
		$this->enableRetainFlashMessages();
		$this->post(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'add'], [
			'title' => 'New article',
			'content' => 'Some body',
			'status' => 'published',
		]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
		$this->assertFlashMessage('The article has been saved and logged to audit trail.');
	}

	/**
	 * @return void
	 */
	public function testEdit(): void {
		$article = SandboxArticleFactory::make()->persist();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'edit', $article->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$article = SandboxArticleFactory::make()->persist();
		$this->enableRetainFlashMessages();

		$this->post(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'delete', $article->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testViewLog(): void {
		$auditLog = AuditLogFactory::make()->persist();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'viewLog', $auditLog->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRevertWrongType(): void {
		$auditLog = AuditLogFactory::make(['type' => AuditLogType::Create->value])->persist();
		$this->enableRetainFlashMessages();

		$this->post(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'revert', $auditLog->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testRestoreWrongType(): void {
		$auditLog = AuditLogFactory::make(['type' => AuditLogType::Update->value])->persist();
		$this->enableRetainFlashMessages();

		$this->post(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'restore', $auditLog->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testPartialRevertWrongType(): void {
		$auditLog = AuditLogFactory::make(['type' => AuditLogType::Create->value])->persist();
		$this->enableRetainFlashMessages();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'partialRevert', $auditLog->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testCustomEvent(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'AuditStash', 'action' => 'customEvent'], ['type' => 'user.login']);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

}
