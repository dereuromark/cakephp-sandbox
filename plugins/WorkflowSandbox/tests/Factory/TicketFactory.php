<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * TicketFactory
 *
 * @method \WorkflowSandbox\Model\Entity\Ticket getEntity()
 * @method array<\WorkflowSandbox\Model\Entity\Ticket> getEntities()
 * @method \WorkflowSandbox\Model\Entity\Ticket|array<\WorkflowSandbox\Model\Entity\Ticket> persist()
 */
class TicketFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Tickets';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'ticket_number' => $generator->unique()->uuid(),
				'subject' => $generator->sentence(4),
				'priority' => 'medium',
				'status' => 'open',
			];
		});
	}

}
