<?php

namespace StateMachineSandbox\Test\TestCase\Queue\Task;

use Cake\TestSuite\TestCase;
use StateMachineSandbox\Queue\Task\SimulatePaymentResultTask;

class SimulatePaymentResultTaskTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.StateMachineSandbox.Registrations',
		'app.Users',
		'app.Roles',
		'plugin.Queue.QueuedJobs',
		'plugin.Queue.QueueProcesses',
		//'plugin.StateMachine.StateMachineItems',
		//'plugin.StateMachine.StateMachineItemStates',
		//'plugin.StateMachine.StateMachineItemStateLogs',
		//'plugin.StateMachine.StateMachineTransitionLogs',
		//'plugin.StateMachine.StateMachineLocks',
		//'plugin.StateMachine.StateMachineProcesses',
	];

	/**
	 * @doesNotPerformAssertions
	 * @return void
	 */
	public function testRun(): void {
		$this->skipIf(true, '/FIXME: insert or update on table "state_machine_item_states" violates foreign key constraint "state_machine_item_states_state_machine_process_id_fkey"');

		$registration = $this->getTableLocator()->get('StateMachineSandbox.Registrations')->newEntity([
			'user_id' => 1,
		]);
		$this->getTableLocator()->get('StateMachineSandbox.Registrations')->saveOrFail($registration);

		$task = new SimulatePaymentResultTask();

		$data = [
			'id' => $registration->id,
		];
		$task->run($data, 0);
	}

}
