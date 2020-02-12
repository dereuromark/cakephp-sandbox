<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\Routing\Router;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\FeedExamplesController
 */
class FeedExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		Router::extensions(['rss']);
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'FeedExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testFeed() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'FeedExamples', 'action' => 'feed', '_ext' => 'rss']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testFeedview() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'FeedExamples', 'action' => 'feedview', 1]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
