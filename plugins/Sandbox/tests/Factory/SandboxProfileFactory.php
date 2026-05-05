<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxProfileFactory
 *
 * @method \Sandbox\Model\Entity\SandboxProfile getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxProfile> getEntities()
 * @method \Sandbox\Model\Entity\SandboxProfile|array<\Sandbox\Model\Entity\SandboxProfile> persist()
 */
class SandboxProfileFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxProfiles';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'username' => $generator->unique()->userName(),
				'balance' => $generator->randomFloat(2, 0, 1000),
				'extra' => $generator->randomFloat(2, 0, 100),
			];
		});
	}

}
