<?php
declare(strict_types=1);

namespace Sandbox\Queue\Task;

use Cake\Core\Configure;
use Mercure\Publisher;
use Mercure\Update\JsonUpdate;
use Queue\Queue\Task;

/**
 * Queue task that publishes real-time progress updates via Mercure.
 *
 * Demonstrates how background jobs can push live updates to the browser
 * without requiring page refresh or polling.
 */
class MercureProgressExampleTask extends Task {

	/**
	 * Timeout for run, after which the Task is reassigned to a new worker.
	 */
	public ?int $timeout = 120;

	/**
	 * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void {
		$topic = $data['topic'] ?? '/sandbox/queue/' . $jobId;
		$duration = (int)($data['duration'] ?? 15);
		$steps = (int)($data['steps'] ?? 10);
		$sleepTime = max(1, (int)($duration / $steps));

		$mercureConfigured = (bool)Configure::read('Mercure.url');

		$this->io->out('MercureProgressExample task started.');
		$this->io->out('Topic: ' . $topic);
		$this->io->out('Duration: ' . $duration . 's, Steps: ' . $steps);

		// Publish start event
		if ($mercureConfigured) {
			$this->publishUpdate($topic, [
				'status' => 'started',
				'progress' => 0,
				'message' => 'Job started',
				'jobId' => $jobId,
			]);
		}

		for ($i = 1; $i <= $steps; $i++) {
			sleep($sleepTime);

			$progress = $i / $steps;
			$percent = (int)($progress * 100);
			$message = "Processing step {$i} of {$steps}";

			// Update queue progress (for DB tracking)
			$this->QueuedJobs->updateProgress($jobId, $progress, $message);

			// Publish Mercure update (for real-time UI)
			if ($mercureConfigured) {
				$this->publishUpdate($topic, [
					'status' => 'progress',
					'progress' => $percent,
					'step' => $i,
					'totalSteps' => $steps,
					'message' => $message,
					'jobId' => $jobId,
				]);
			}

			$this->io->out("Progress: {$percent}% - {$message}");
		}

		// Publish completion event
		if ($mercureConfigured) {
			$this->publishUpdate($topic, [
				'status' => 'completed',
				'progress' => 100,
				'message' => 'Job completed successfully!',
				'jobId' => $jobId,
			]);
		}

		$this->QueuedJobs->updateProgress($jobId, 1, 'Completed');
		$this->io->success('MercureProgressExample task completed.');
	}

	/**
	 * Publish a Mercure update.
	 *
	 * @param string $topic
	 * @param array<string, mixed> $data
	 * @return void
	 */
	protected function publishUpdate(string $topic, array $data): void {
		try {
			Publisher::publish(JsonUpdate::create(
				topics: $topic,
				data: $data,
			));
		} catch (\Exception $e) {
			$this->io->error('Mercure publish failed: ' . $e->getMessage());
		}
	}

}
