<?php

namespace App\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \App\Controller\MiscController
 */
class MiscControllerTest extends IntegrationTestCase {

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['controller' => 'Misc', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testConvertText() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['controller' => 'Misc', 'action' => 'convertText']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test dtoProjection action
	 *
	 * @return void
	 */
	public function testDtoProjection(): void {
		$this->get(['controller' => 'Misc', 'action' => 'dtoProjection']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
