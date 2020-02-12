<?php

namespace App\Test\TestCase\Shell\Task;

use App\Shell\Task\QueueMyTaskNameTask;
use Cake\TestSuite\TestCase;

class QueueMyTaskNameTaskTest extends TestCase {

	/**
	 * @var string[]
	 */
	public $fixtures = [
		'plugin.Queue.QueuedJobs',
		'plugin.Queue.QueueProcesses',
	];

	/**
	 * @return void
	 */
	public function testRun(): void {
		$task = new QueueMyTaskNameTask();
		$data = [];

		//TODO
		$task->run($data, 0);

		$this->assertSame([], $data);
	}

}
