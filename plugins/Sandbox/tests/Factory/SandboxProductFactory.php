<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxProductFactory
 *
 * @method \Sandbox\Model\Entity\SandboxProduct getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxProduct> getEntities()
 * @method \Sandbox\Model\Entity\SandboxProduct|array<\Sandbox\Model\Entity\SandboxProduct> persist()
 */
class SandboxProductFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxProducts';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			$now = $generator->dateTime();

			return [
				'title' => $generator->sentence(2),
				'price' => $generator->randomFloat(2, 1, 100),
				'stock' => $generator->numberBetween(0, 50),
				'created' => $now,
				'modified' => $now,
			];
		});
	}

}
