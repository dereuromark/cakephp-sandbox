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
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'code' => strtoupper(substr($generator->word(), 0, 2)),
			'name' => $generator->word(),
			'lat' => $generator->randomFloat(6, -90, 90),
			'lng' => $generator->randomFloat(6, -180, 180),
		];
	}

	/**
	 * Compose the parent via the association instead of a dangling FK id in
	 * definition() (strict-definition rule).
	 *
	 * @return static
	 */
	protected function configure(): static {
		return $this->with('Countries', CountryFactory::new());
	}

}
