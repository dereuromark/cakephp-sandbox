<?php

namespace Sandbox\Test\TestCase\Controller;

use Tools\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\QueueExamplesController
 */
class QueueExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Queue.QueuedJobs',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'QueueExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
