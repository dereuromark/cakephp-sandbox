<?php
declare(strict_types=1);

namespace WorkflowSandbox\Queue\Task;

use Cake\Datasource\Exception\RecordNotFoundException;
use Queue\Queue\Task;

/**
 * Processes order workflow transitions asynchronously.
 *
 * Handles transitions like:
 * - pay: Simulates payment processing
 * - ship: Simulates shipping the order
 * - deliver: Simulates delivery confirmation
 */
class ProcessOrderTask extends Task {

	/**
	 * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void {
		$transition = $data['transition'] ?? null;
		if (!$transition) {
			return;
		}

		/** @var \WorkflowSandbox\Model\Table\OrdersTable $ordersTable */
		$ordersTable = $this->fetchTable('WorkflowSandbox.Orders');

		try {
			$order = $ordersTable->get($data['id']);
		} catch (RecordNotFoundException) {
			// Order was deleted
			return;
		}

		// Check if transition is allowed
		if (!$ordersTable->canTransition($order, $transition)) {
			return;
		}

		// Build context based on transition
		$context = $this->buildContext($transition, $data);

		// Apply the transition
		$result = $ordersTable->applyTransition($order, $transition, $context);

		if ($result->isSuccess()) {
			$ordersTable->saveOrFail($order);

			// Schedule follow-up transitions if needed
			$this->scheduleFollowUp($order, $transition, $data);
		}
	}

	/**
	 * Build context data for the transition.
	 *
	 * @param string $transition
	 * @param array<string, mixed> $data
	 * @return array<string, mixed>
	 */
	protected function buildContext(string $transition, array $data): array {
		$context = [
			'simulated' => true,
			'processed_at' => date('Y-m-d H:i:s'),
		];

		return match ($transition) {
			'pay' => $context + [
				'payment_method' => $data['payment_method'] ?? 'demo_card',
				'transaction_id' => 'TXN_' . uniqid(),
			],
			'ship' => $context + [
				'tracking_number' => 'TRACK_' . strtoupper(substr(md5((string)$data['id']), 0, 10)),
				'carrier' => $data['carrier'] ?? 'DemoShip',
			],
			'deliver' => $context + [
				'delivered_at' => date('Y-m-d H:i:s'),
				'signature' => 'Demo Signature',
			],
			default => $context,
		};
	}

	/**
	 * Schedule follow-up transitions for demo purposes.
	 *
	 * @param \WorkflowSandbox\Model\Entity\Order $order
	 * @param string $completedTransition
	 * @param array<string, mixed> $data
	 * @return void
	 */
	protected function scheduleFollowUp($order, string $completedTransition, array $data): void {
		if (!($data['auto_progress'] ?? false)) {
			return;
		}

		/** @var \Queue\Model\Table\QueuedJobsTable $queuedJobsTable */
		$queuedJobsTable = $this->fetchTable('Queue.QueuedJobs');

		// Auto-progress through happy path for demo
		$nextTransition = match ($completedTransition) {
			'pay' => 'ship',
			'ship' => 'deliver',
			default => null,
		};

		if ($nextTransition) {
			$queuedJobsTable->createJob('WorkflowSandbox.ProcessOrder', [
				'id' => $order->id,
				'transition' => $nextTransition,
				'auto_progress' => true,
			], [
				'notBefore' => '+30 seconds', // Simulate processing time
			]);
		}
	}

}
