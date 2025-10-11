<?php

namespace StateMachineSandbox\StateMachine\Command\Registration;

use Cake\ORM\Locator\LocatorAwareTrait;
use StateMachine\Dependency\StateMachineCommandInterface;
use StateMachine\Dto\StateMachine\ItemDto;

class CompleteCommand implements StateMachineCommandInterface {

	use LocatorAwareTrait;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return void
	 */
	public function run(ItemDto $itemDto): void {
		$registrationId = $itemDto->getIdentifierOrFail();

		/** @var \StateMachineSandbox\Model\Table\RegistrationsTable $Registrations */
		$Registrations = $this->fetchTable('StateMachineSandbox.Registrations');
		$registration = $Registrations->get($registrationId);
		$registration->status = 'complete';

		$Registrations->saveOrFail($registration);
	}

}
