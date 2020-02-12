<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\QueueExamplesController
 */
class QueueExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Queue.QueuedJobs',
		'plugin.Queue.QueueProcesses',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'QueueExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testScheduling() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'QueueExamples', 'action' => 'scheduling']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testConfig() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'QueueExamples', 'action' => 'config']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testCancelJob() {
		$this->disableErrorHandlerMiddleware();

		$queuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
		$queuedJob = $queuedJobs->newEntity([
			'job_type' => 'ProgressExample',
			'reference' => 'demo-',
		]);
		$queuedJobs->saveOrFail($queuedJob);

		$this->post(['plugin' => 'Sandbox', 'controller' => 'QueueExamples', 'action' => 'cancelJob', $queuedJob->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * @return void
	 */
	public function testScheduleDemo() {
		$this->disableErrorHandlerMiddleware();

		$this->post(['plugin' => 'Sandbox', 'controller' => 'QueueExamples', 'action' => 'scheduleDemo']);

		$this->assertResponseCode(302);
		$this->assertRedirect();

		$queuedJobs = TableRegistry::getTableLocator()->get('Queue.QueuedJobs');
		/** @var \Queue\Model\Entity\QueuedJob $queuedJob */
		$queuedJob = $queuedJobs->find()->orderDesc('id')->firstOrFail();
		$this->assertSame('ProgressExample', $queuedJob->job_type);
	}

}
