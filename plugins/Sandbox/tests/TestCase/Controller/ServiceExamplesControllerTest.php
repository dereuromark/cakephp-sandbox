<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\ServiceExamplesController Test Case
 *
 * @uses \Sandbox\Controller\ServiceExamplesController
 */
class ServiceExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ServiceExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test posts method
	 *
	 * @return void
	 */
	public function testPosts(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ServiceExamples', 'action' => 'posts']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
