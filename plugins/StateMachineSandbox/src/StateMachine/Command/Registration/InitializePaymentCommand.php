<?php

namespace StateMachineSandbox\StateMachine\Command\Registration;

use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\DateTime;
use Queue\Model\Table\QueuedJobsTable;
use StateMachine\Dependency\StateMachineCommandInterface;
use StateMachine\Dto\StateMachine\ItemDto;

class InitializePaymentCommand implements StateMachineCommandInterface {

	use ModelAwareTrait;

	protected QueuedJobsTable $QueuedJobs;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return void
	 */
	public function run(ItemDto $itemDto): void {
		$registrationId = $itemDto->getIdentifierOrFail();

		/** @var \Queue\Model\Table\QueuedJobsTable $QueuedJobs */
		$QueuedJobs = $this->fetchModel('Queue.QueuedJobs');
		$reference = 'registration-' . $registrationId;
		$QueuedJobs->createJob(
			'StateMachineSandbox.SimulatePaymentResult',
			['id' => $registrationId],
			['reference' => $reference, 'notBefore' => (new DateTime())->addMinutes(1)],
		);
	}

}
