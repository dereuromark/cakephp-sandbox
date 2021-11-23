<?php

namespace StateMachineSandbox\StateMachine\Condition\Registration;

use Cake\Datasource\ModelAwareTrait;
use Cake\ORM\Locator\LocatorAwareTrait;
use StateMachine\Dependency\StateMachineConditionInterface;
use StateMachine\Dto\StateMachine\ItemDto;

/**
 * @property \StateMachineSandbox\Model\Table\RegistrationsTable $Registrations
 */
class CheckApprovalCondition implements StateMachineConditionInterface {

	use ModelAwareTrait;
	use LocatorAwareTrait;

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return bool
	 */
	public function check(ItemDto $itemDto): bool {
		$registrationId = $itemDto->getIdentifierOrFail();

		$this->loadModel('StateMachineSandbox.Registrations');
		$registration = $this->Registrations->get($registrationId, ['contain' => ['Users' => ['Roles']]]);
		if ($registration->user && $registration->user->role && $registration->user->role->alias === 'mod') {
			return true;
		}

		return false;
	}

}
