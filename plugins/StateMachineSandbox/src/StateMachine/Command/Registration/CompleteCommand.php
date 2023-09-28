<?php

namespace StateMachineSandbox\StateMachine\Command\Registration;

use Cake\Datasource\ModelAwareTrait;
use StateMachine\Dependency\StateMachineCommandInterface;
use StateMachine\Dto\StateMachine\ItemDto;

class CompleteCommand implements StateMachineCommandInterface {

	use ModelAwareTrait;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return void
	 */
	public function run(ItemDto $itemDto): void {
		$registrationId = $itemDto->getIdentifierOrFail();

		/** @var \StateMachineSandbox\Model\Table\RegistrationsTable $Registrations */
		$Registrations = $this->fetchModel('StateMachineSandbox.Registrations');
		$registration = $Registrations->get($registrationId);
		$registration->status = 'complete';

		$Registrations->saveOrFail($registration);
	}

}
