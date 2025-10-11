<?php

namespace StateMachineSandbox\StateMachine\Command\Registration;

use Cake\I18n\DateTime;
use Cake\ORM\Locator\LocatorAwareTrait;
use StateMachine\Dependency\StateMachineCommandInterface;
use StateMachine\Dto\StateMachine\ItemDto;

class InitializePaymentCommand implements StateMachineCommandInterface {

	use LocatorAwareTrait;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return void
	 */
	public function run(ItemDto $itemDto): void {
		$registrationId = $itemDto->getIdentifierOrFail();

		/** @var \Queue\Model\Table\QueuedJobsTable $QueuedJobs */
		$QueuedJobs = $this->fetchTable('Queue.QueuedJobs');
		$reference = 'registration-' . $registrationId;
		$QueuedJobs->createJob(
			'StateMachineSandbox.SimulatePaymentResult',
			['id' => $registrationId],
			['reference' => $reference, 'notBefore' => (new DateTime())->addMinutes(1)],
		);
	}

}
