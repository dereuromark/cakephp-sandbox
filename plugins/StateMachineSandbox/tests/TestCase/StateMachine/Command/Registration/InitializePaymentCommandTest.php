<?php

namespace StateMachineSandbox\Test\TestCase\StateMachine\Command\Registration;

use Cake\TestSuite\TestCase;
use StateMachine\Dto\StateMachine\ItemDto;
use StateMachineSandbox\StateMachine\Command\Registration\InitializePaymentCommand;
use StateMachineSandbox\StateMachine\RegistrationStateMachineHandler;

class InitializePaymentCommandTest extends TestCase {

	/**
	 * @return void
	 */
	public function testRun(): void {
		$command = new InitializePaymentCommand();

		$itemDto = new ItemDto();
		$itemDto->setIdentifier(1);
		$itemDto->setStateMachineName(RegistrationStateMachineHandler::NAME);
		$itemDto->setStateName(RegistrationStateMachineHandler::STATE_WAITING_FOR_PAYMENT);
		$itemDto->setProcessName('Registration01');

		$command->run($itemDto);

		$reference = 'registration-1';
		/** @var \Queue\Model\Entity\QueuedJob $queuedJob */
		$queuedJob = $this->getTableLocator()->get('Queue.QueuedJobs')->find()->orderByDesc('id')->firstOrFail();
		$this->assertSame($reference, $queuedJob->reference);
	}

}
