<?php

namespace StateMachineSandbox\Queue\Task;

use Cake\Datasource\ModelAwareTrait;
use Queue\Queue\Task;
use StateMachine\Business\StateMachineFacade;
use StateMachine\Dto\StateMachine\ItemDto;
use StateMachineSandbox\StateMachine\RegistrationStateMachineHandler;

/**
 * @property \StateMachineSandbox\Model\Table\RegistrationsTable $Registrations
 */
class SimulatePaymentResultTask extends Task {

	use ModelAwareTrait;

	/**
	 * We simulate an external ping/API-call to our website, confirming the payment.
	 *
	 * @param array<string, mixed> $data The array passed to QueuedJobsTable::createJob()
	 * @param int $jobId The id of the QueuedJob entity
	 * @return void
	 */
	public function run(array $data, int $jobId): void {
		$this->loadModel('StateMachineSandbox.Registrations');
		$registration = $this->Registrations->get($data['id'], ['contain' => ['RegistrationStates']]);

		$stateMachineFacade = new StateMachineFacade();
		$itemDto = new ItemDto();
		$itemDto->setIdentifier($registration->id);
		$itemDto->setStateMachineName(RegistrationStateMachineHandler::NAME);
		$itemDto->setStateName(RegistrationStateMachineHandler::STATE_WAITING_FOR_PAYMENT);
		$itemDto->setProcessName($registration->registration_state->process);

		$stateMachineFacade->triggerEvent(RegistrationStateMachineHandler::EVENT_CONFIRM_PAYMENT, $itemDto);
	}

}
