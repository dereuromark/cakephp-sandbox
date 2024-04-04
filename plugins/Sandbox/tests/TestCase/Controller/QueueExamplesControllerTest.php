<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\QueueExamplesController
 */
class QueueExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
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
			'job_task' => 'Queue.ProgressExample',
			'reference' => 'demo-cli',
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
		$queuedJob = $queuedJobs->find()->orderByDesc('id')->firstOrFail();
		$this->assertSame('Queue.ProgressExample', $queuedJob->job_task);
	}

}
