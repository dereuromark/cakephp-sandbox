<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * OrderFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\WorkflowSandbox\Model\Entity\Order>
 */
class OrderFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Orders';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'order_number' => $generator->unique()->uuid(),
			'status' => 'pending',
			'total' => $generator->randomFloat(2, 1, 500),
		];
	}

}
