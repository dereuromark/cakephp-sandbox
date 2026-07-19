<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use App\Test\Factory\CountryFactory;
use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxCityFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Sandbox\Model\Entity\SandboxCity>
 */
class SandboxCityFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxCities';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'name' => $generator->city(),
			'alias' => $generator->word(),
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
