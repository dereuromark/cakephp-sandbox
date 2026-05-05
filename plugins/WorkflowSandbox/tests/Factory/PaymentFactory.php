<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * PaymentFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\WorkflowSandbox\Model\Entity\Payment>
 */
class PaymentFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Payments';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'transaction_id' => $generator->unique()->uuid(),
			'amount' => $generator->randomFloat(2, 1, 1000),
			'currency' => 'USD',
			'status' => 'pending',
			'retry_count' => 0,
		];
	}

}
