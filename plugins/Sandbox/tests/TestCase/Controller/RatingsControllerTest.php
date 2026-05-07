<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Sandbox\Test\Factory\SandboxRatingFactory;

/**
 * Sandbox\Controller\RatingsController Test Case
 *
 * @uses \Sandbox\Controller\RatingsController
 */
class RatingsControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Ratings', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test unrate method
	 *
	 * @return void
	 */
	public function testUnrate(): void {
		$this->disableErrorHandlerMiddleware();
		$this->enableRetainFlashMessages();

		$rating = SandboxRatingFactory::new()->save();

		$this->post(['plugin' => 'Sandbox', 'controller' => 'Ratings', 'action' => 'unrate', $rating->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

}
