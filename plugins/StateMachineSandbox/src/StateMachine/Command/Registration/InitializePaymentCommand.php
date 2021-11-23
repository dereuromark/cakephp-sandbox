<?php

namespace StateMachineSandbox\StateMachine\Command\Registration;

use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\FrozenTime;
use StateMachine\Dependency\StateMachineCommandInterface;
use StateMachine\Dto\StateMachine\ItemDto;

/**
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class InitializePaymentCommand implements StateMachineCommandInterface {

	use ModelAwareTrait;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return void
	 */
	public function run(ItemDto $itemDto): void {
		$registrationId = $itemDto->getIdentifierOrFail();

		$this->loadModel('Queue.QueuedJobs');
		$reference = 'registration-' . $registrationId;
		$this->QueuedJobs->createJob(
			'StateMachineSandbox.SimulatePaymentResult',
			['id' => $registrationId],
			['reference' => $reference, 'notBefore' => (new FrozenTime())->addMinute()],
		);
	}

}
