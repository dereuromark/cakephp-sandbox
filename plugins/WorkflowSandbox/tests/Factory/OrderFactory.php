<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * OrderFactory
 *
 * @method \WorkflowSandbox\Model\Entity\Order getEntity()
 * @method array<\WorkflowSandbox\Model\Entity\Order> getEntities()
 * @method \WorkflowSandbox\Model\Entity\Order|array<\WorkflowSandbox\Model\Entity\Order> persist()
 */
class OrderFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Orders';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'order_number' => $generator->unique()->uuid(),
				'status' => 'pending',
				'total' => $generator->randomFloat(2, 1, 500),
			];
		});
	}

}
