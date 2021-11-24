<?php

namespace StateMachineSandbox\StateMachine;

use StateMachine\Dependency\StateMachineHandlerInterface;
use StateMachine\Dto\StateMachine\ItemDto;
use StateMachineSandbox\StateMachine\Command\Registration\CompleteCommand;
use StateMachineSandbox\StateMachine\Command\Registration\InitializePaymentCommand;
use StateMachineSandbox\StateMachine\Command\Registration\SendConfirmationCommand;
use StateMachineSandbox\StateMachine\Condition\Registration\CheckApprovalCondition;

class RegistrationStateMachineHandler implements StateMachineHandlerInterface {

	/**
	 * @var string
	 */
	public const NAME = 'Registration';

	/**
	 * @var string
	 */
	public const STATE_INIT = 'init';

	/**
	 * @var string
	 */
	public const STATE_WAITING_FOR_APPROVAL = 'waiting for approval';

	/**
	 * @var string
	 */
	public const STATE_APPROVED = 'approved';

	/**
	 * @var string
	 */
	public const STATE_WAITING_FOR_PAYMENT = 'waiting for payment';

	/**
	 * @var string
	 */
	public const STATE_PAYMENT_RECEIVED = 'payment received';

	/**
	 * @var string
	 */
	public const STATE_CONFIRMATION_SENT = 'confirmation sent';

	/**
	 * @var string
	 */
	public const STATE_DONE = 'done';

	/**
	 * @var string
	 */
	public const EVENT_APPROVE = 'approve';

	/**
	 * @var string
	 */
	public const EVENT_CONFIRM_PAYMENT = 'confirm payment';

	/**
	 * @var string
	 */
	public const EVENT_CHECK_APPROVAL = 'check approval';

	/**
	 * @var string
	 */
	public const EVENT_INITIALIZE_PAYMENT = 'initialize payment';

	/**
	 * @var string
	 */
	public const EVENT_SEND_CONFIRMATION = 'send confirmation';

	/**
	 * @var string
	 */
	public const EVENT_COMPLETE_REGISTRATION = 'complete registration';

	/**
	 * {@inheritDoc]
	 *
	 * @return array<string>
	 */
	public function getCommands(): array {
		return [
			'Registration/InitializePayment' => InitializePaymentCommand::class,
			'Registration/SendConfirmation' => SendConfirmationCommand::class,
			'Registration/Complete' => CompleteCommand::class,
		];
	}

	/**
	 * {@inheritDoc]
	 *
	 * @return array<string>
	 */
	public function getConditions(): array {
		return [
			'Registration/CheckApproval' => CheckApprovalCondition::class,
		];
	}

	/**
	 * {@inheritDoc]
	 *
	 * @return string
	 */
	public function getStateMachineName(): string {
		return static::NAME;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return array<string>
	 */
	public function getActiveProcesses(): array {
		return [
			'Registration01',
		];
	}

	/**
	 * {@inheritDoc]
	 *
	 * @param string $processName
	 *
	 * @return string
	 */
	public function getInitialStateForProcess($processName): string {
		return static::STATE_INIT;
	}

	/**
	 * {@inheritDoc]
	 *
	 * @param \StateMachine\Dto\StateMachine\ItemDto $itemDto
	 *
	 * @return bool
	 */
	public function itemStateUpdated(ItemDto $itemDto): bool {
		return true;
	}

	/**
	 * {@inheritDoc]
	 *
	 * @param array<int> $stateIds
	 *
	 * @return array<\StateMachine\Dto\StateMachine\ItemDto>
	 */
	public function getStateMachineItemsByStateIds(array $stateIds = []): array {
		return [];
	}

}
