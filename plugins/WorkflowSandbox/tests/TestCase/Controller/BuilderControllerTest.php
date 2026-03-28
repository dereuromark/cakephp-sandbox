<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \WorkflowSandbox\Controller\BuilderController
 */
class BuilderControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Workflow Builder');
		$this->assertResponseContains('NEON Editor');
	}

	/**
	 * @return void
	 */
	public function testLoadExampleOrder(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'loadExample', 'order']);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$this->assertResponseContains('"success":true');
		$this->assertResponseContains('order:');
	}

	/**
	 * @return void
	 */
	public function testLoadExampleRegistration(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'loadExample', 'registration']);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$this->assertResponseContains('"success":true');
	}

	/**
	 * @return void
	 */
	public function testLoadExampleContent(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'loadExample', 'content']);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$this->assertResponseContains('"success":true');
	}

	/**
	 * @return void
	 */
	public function testLoadExampleTicket(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'loadExample', 'ticket']);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$this->assertResponseContains('"success":true');
	}

	/**
	 * @return void
	 */
	public function testLoadExampleDocument(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'loadExample', 'document']);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$this->assertResponseContains('"success":true');
	}

	/**
	 * @return void
	 */
	public function testLoadExampleInvalidFallsBackToOrder(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'loadExample', 'invalid']);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$this->assertResponseContains('"success":true');
		$this->assertResponseContains('"name":"order"');
	}

	/**
	 * @return void
	 */
	public function testPreviewValidNeon(): void {
		$this->disableErrorHandlerMiddleware();
		$this->enableCsrfToken();

		$neon = <<<NEON
test:
    table: Test.Tests
    field: status
    states:
        draft:
            initial: true
        published:
            final: true
    transitions:
        publish:
            from: [draft]
            to: published
NEON;

		$this->post(
			['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'preview'],
			['neon' => $neon],
		);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$this->assertResponseContains('"success":true');
		$this->assertResponseContains('"mermaid"');
	}

	/**
	 * @return void
	 */
	public function testPreviewInvalidNeon(): void {
		$this->disableErrorHandlerMiddleware();
		$this->enableCsrfToken();

		$this->post(
			['plugin' => 'WorkflowSandbox', 'controller' => 'Builder', 'action' => 'preview'],
			['neon' => 'invalid: [unclosed'],
		);

		$this->assertResponseCode(200);
		$this->assertContentType('application/json');
		$this->assertResponseContains('"success":false');
	}

}
