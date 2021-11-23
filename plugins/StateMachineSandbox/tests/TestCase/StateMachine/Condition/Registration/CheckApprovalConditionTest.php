<?php

namespace StateMachineSandbox\Test\TestCase\StateMachine\Condition\Registration;

use Cake\TestSuite\TestCase;
use StateMachine\Dto\StateMachine\ItemDto;
use StateMachineSandbox\StateMachine\Condition\Registration\CheckApprovalCondition;
use StateMachineSandbox\StateMachine\RegistrationStateMachineHandler;

class CheckApprovalConditionTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected $fixtures = [
		'plugin.StateMachineSandbox.Registrations',
		'app.Users',
		'app.Roles',
	];

	/**
	 * @return void
	 */
	public function testRun(): void {
		$condition = new CheckApprovalCondition();

		$itemDto = new ItemDto();
		$itemDto->setIdentifier(1);
		$itemDto->setStateMachineName(RegistrationStateMachineHandler::NAME);
		$itemDto->setStateName(RegistrationStateMachineHandler::STATE_WAITING_FOR_PAYMENT);
		$itemDto->setProcessName('Registration01');

		$result = $condition->check($itemDto);
		$this->assertFalse($result);
	}

}
