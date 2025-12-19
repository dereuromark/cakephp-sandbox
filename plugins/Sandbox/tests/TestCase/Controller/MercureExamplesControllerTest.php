<?php

namespace Sandbox\Test\TestCase\Controller;

use Mercure\Publisher;
use Mercure\TestSuite\MockPublisher;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\MercureExamplesController
 */
class MercureExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		// Mock Mercure publisher to prevent actual HTTP requests during tests
		Publisher::setInstance(new MockPublisher());
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		Publisher::clear();
	}

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MercureExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('What is Mercure?');
	}

	/**
	 * @return void
	 */
	public function testPublishing(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MercureExamples', 'action' => 'publishing']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Publishing Updates');
	}

	/**
	 * @return void
	 */
	public function testAuthorization(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MercureExamples', 'action' => 'authorization']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Authorization for Private Topics');
	}

	/**
	 * @return void
	 */
	public function testSubscription(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MercureExamples', 'action' => 'subscription']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Client-Side Subscription');
	}

	/**
	 * @return void
	 */
	public function testQueueProgress(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MercureExamples', 'action' => 'queueProgress']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Queue Integration');
	}

	/**
	 * @return void
	 */
	public function testScheduleQueueDemo(): void {
		$this->enableRetainFlashMessages();
		$this->post(['plugin' => 'Sandbox', 'controller' => 'MercureExamples', 'action' => 'scheduleQueueDemo']);

		$this->assertRedirect(['action' => 'queueProgress']);
	}

}
