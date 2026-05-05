<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;

/**
 * RegistrationFactory
 *
 * @method \WorkflowSandbox\Model\Entity\Registration getEntity()
 * @method array<\WorkflowSandbox\Model\Entity\Registration> getEntities()
 * @method \WorkflowSandbox\Model\Entity\Registration|array<\WorkflowSandbox\Model\Entity\Registration> persist()
 */
class RegistrationFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Registrations';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(fn (): array => [
			'status' => 'pending',
		]);
	}

}
