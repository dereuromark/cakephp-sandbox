<?php

namespace StateMachineSandbox\StateMachine\Command\Registration;

use StateMachine\Dependency\StateMachineCommandInterface;
use StateMachine\Dto\StateMachine\ItemDto;

class SendConfirmationCommand implements StateMachineCommandInterface {

	/**
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return void
	 */
	public function run(ItemDto $itemDto): void {
		// TODO: Trigger notification email functionality as queue job.
	}

}
