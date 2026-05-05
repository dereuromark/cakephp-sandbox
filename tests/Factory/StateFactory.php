<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * StateFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Data\Model\Entity\State>
 */
class StateFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Data.States';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'country_id' => 1,
				'code' => strtoupper(substr($generator->word(), 0, 2)),
				'name' => $generator->word(),
				'lat' => $generator->randomFloat(6, -90, 90),
				'lng' => $generator->randomFloat(6, -180, 180),
			];
		});
	}

}
