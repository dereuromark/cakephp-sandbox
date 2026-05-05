<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxCityFactory
 *
 * @method \Sandbox\Model\Entity\SandboxCity getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxCity> getEntities()
 * @method \Sandbox\Model\Entity\SandboxCity|array<\Sandbox\Model\Entity\SandboxCity> persist()
 */
class SandboxCityFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxCities';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'name' => $generator->city(),
				'alias' => $generator->word(),
				'country_id' => 1,
				'lat' => $generator->randomFloat(6, -90, 90),
				'lng' => $generator->randomFloat(6, -180, 180),
			];
		});
	}

}
