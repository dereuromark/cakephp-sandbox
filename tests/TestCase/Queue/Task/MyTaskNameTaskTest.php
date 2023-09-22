<?php

namespace App\Test\TestCase\Queue\Task;

use App\Queue\Task\MyTaskNameTask;
use Cake\TestSuite\TestCase;

class MyTaskNameTaskTest extends TestCase {

	/**
	 * @var array<string>
	 */
	public array $fixtures = [
		'plugin.Queue.QueuedJobs',
		'plugin.Queue.QueueProcesses',
	];

	/**
	 * @return void
	 */
	public function testRun(): void {
		$task = new MyTaskNameTask();
		$data = [];

		//TODO
		$task->run($data, 0);

		$this->assertSame([], $data);
	}

}
