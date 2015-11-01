<?php

namespace Sandbox\Test\TestCase\Controller;

use Sandbox\Controller\FeedExamplesController;
use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;
use Cake\Routing\Router;

/**
 * FeedExamples
 */
class FeedExamplesControllerTest extends IntegrationTestCase {

	public function setUp() {
		parent::setUp();

		Router::extensions(['rss']);
	}

	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'FeedExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testFeed() {
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
