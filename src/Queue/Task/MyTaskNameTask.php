<?php

namespace App\Queue\Task;

use Queue\Queue\Task;

class MyTaskNameTask extends Task {

	/**
	 * @param array $data
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void {
	}

}
