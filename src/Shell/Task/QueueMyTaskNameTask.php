<?php

namespace App\Shell\Task;

use Queue\Shell\Task\QueueTask;

class QueueMyTaskNameTask extends QueueTask {

	/**
	 * @param array $data
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void {
	}

}
