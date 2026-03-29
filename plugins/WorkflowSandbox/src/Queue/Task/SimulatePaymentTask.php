<?php
declare(strict_types=1);

namespace WorkflowSandbox\Queue\Task;

use Cake\Datasource\Exception\RecordNotFoundException;
use Queue\Queue\Task;

/**
 * Simulates an external payment gateway callback.
 *
 * This task represents what would happen when a payment provider
 * sends a webhook/callback confirming payment.
 */
class SimulatePaymentTask extends Task {

	/**
	 * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void {
		/** @var \WorkflowSandbox\Model\Table\RegistrationsTable $registrationsTable */
		$registrationsTable = $this->fetchTable('WorkflowSandbox.Registrations');

		try {
			$registration = $registrationsTable->get($data['id']);
		} catch (RecordNotFoundException) {
			// Registration was deleted, nothing to do
			return;
		}

		// Check if we can apply the confirm_payment transition
		if (!$registrationsTable->canTransition($registration, 'confirm_payment')) {
			return;
		}

		// Apply the transition
		$result = $registrationsTable->applyTransition($registration, 'confirm_payment', [
			'payment_method' => $data['payment_method'] ?? 'demo',
			'simulated' => true,
		]);

		if ($result->isSuccess()) {
			$registrationsTable->saveOrFail($registration);
		}
	}

}
