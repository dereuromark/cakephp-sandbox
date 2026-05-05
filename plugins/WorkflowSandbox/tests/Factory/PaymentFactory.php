<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * PaymentFactory
 *
 * @method \WorkflowSandbox\Model\Entity\Payment getEntity()
 * @method array<\WorkflowSandbox\Model\Entity\Payment> getEntities()
 * @method \WorkflowSandbox\Model\Entity\Payment|array<\WorkflowSandbox\Model\Entity\Payment> persist()
 */
class PaymentFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Payments';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'transaction_id' => $generator->unique()->uuid(),
				'amount' => $generator->randomFloat(2, 1, 1000),
				'currency' => 'USD',
				'status' => 'pending',
				'retry_count' => 0,
			];
		});
	}

}
