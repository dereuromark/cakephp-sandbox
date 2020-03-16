<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\ConventionsController Test Case
 *
 * @uses \Sandbox\Controller\ConventionsController
 */
class ConventionsControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Conventions', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
