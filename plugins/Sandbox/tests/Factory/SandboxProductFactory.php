<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxProductFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Sandbox\Model\Entity\Product>
 */
class SandboxProductFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.Products';
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
