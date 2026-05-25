<?php
declare(strict_types=1);

namespace MenuSandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \MenuSandbox\Controller\MenuSandboxController
 */
class MenuSandboxControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @uses \MenuSandbox\Controller\MenuSandboxController::index()
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \MenuSandbox\Controller\MenuSandboxController::resolvers()
	 * @return void
	 */
	public function testResolvers(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'resolvers']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \MenuSandbox\Controller\MenuSandboxController::renderers()
	 * @return void
	 */
	public function testRenderers(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'renderers']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \MenuSandbox\Controller\MenuSandboxController::advanced()
	 * @return void
	 */
	public function testAdvanced(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'MenuSandbox', 'controller' => 'MenuSandbox', 'action' => 'advanced']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
