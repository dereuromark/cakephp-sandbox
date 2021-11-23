<?php

namespace StateMachineSandbox\StateMachine\Command\Registration;

use Cake\Datasource\ModelAwareTrait;
use StateMachine\Dependency\StateMachineCommandInterface;
use StateMachine\Dto\StateMachine\ItemDto;

/**
 * @property \StateMachineSandbox\Model\Table\RegistrationsTable $Registrations
 */
class CompleteCommand implements StateMachineCommandInterface {

	use ModelAwareTrait;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return void
	 */
	public function run(ItemDto $itemDto): void {
		$registrationId = $itemDto->getIdentifierOrFail();

		$this->loadModel('StateMachineSandbox.Registrations');
		$registration = $this->Registrations->get($registrationId);
		$registration->status = 'complete';

		$this->Registrations->saveOrFail($registration);
	}

}
