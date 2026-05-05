<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxAnimalFactory
 *
 * @method \Sandbox\Model\Entity\SandboxAnimal getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxAnimal> getEntities()
 * @method \Sandbox\Model\Entity\SandboxAnimal|array<\Sandbox\Model\Entity\SandboxAnimal> persist()
 */
class SandboxAnimalFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxAnimals';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'name' => $generator->sentence(2),
			];
		});
	}

}
