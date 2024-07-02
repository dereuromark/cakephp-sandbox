<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Sandbox\Controller\LocalizedController
 */
class LocalizedControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @uses \Sandbox\Controller\LocalizedController::index()
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Localized', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\LocalizedController::basic()
	 * @return void
	 */
	public function testBasic(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Localized', 'action' => 'basic']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
