<?php

namespace StateMachineSandbox\StateMachine\Condition\Registration;

use Cake\ORM\Locator\LocatorAwareTrait;
use StateMachine\Dependency\StateMachineConditionInterface;
use StateMachine\Dto\StateMachine\ItemDto;

class CheckApprovalCondition implements StateMachineConditionInterface {

	use LocatorAwareTrait;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return bool
	 */
	public function check(ItemDto $itemDto): bool {
		$registrationId = $itemDto->getIdentifierOrFail();

		/** @var \StateMachineSandbox\Model\Table\RegistrationsTable $Registrations */
		$Registrations = $this->fetchTable('StateMachineSandbox.Registrations');
		$registration = $Registrations->get($registrationId, contain: ['Users' => ['Roles']]);
		if ($registration->user && $registration->user->role && $registration->user->role->alias === 'mod') {
			return true;
		}

		return false;
	}

}
