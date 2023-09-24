<?php

namespace StateMachineSandbox\StateMachine\Condition\Registration;

use Cake\Datasource\ModelAwareTrait;
use Cake\ORM\Locator\LocatorAwareTrait;
use StateMachine\Dependency\StateMachineConditionInterface;
use StateMachine\Dto\StateMachine\ItemDto;
use StateMachineSandbox\Model\Table\RegistrationsTable;

class CheckApprovalCondition implements StateMachineConditionInterface {

	use ModelAwareTrait;
	use LocatorAwareTrait;

	protected RegistrationsTable $Registrations;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return bool
	 */
	public function check(ItemDto $itemDto): bool {
		$registrationId = $itemDto->getIdentifierOrFail();

		$this->loadModel('StateMachineSandbox.Registrations');
		$registration = $this->Registrations->get($registrationId, contain: ['Users' => ['Roles']]);
		if ($registration->user && $registration->user->role && $registration->user->role->alias === 'mod') {
			return true;
		}

		return false;
	}

}
