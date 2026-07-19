<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxRatingFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Sandbox\Model\Entity\SandboxRating>
 */
class SandboxRatingFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxRatings';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'foreign_key' => 1,
			'model' => 'Posts',
			'value' => $generator->numberBetween(1, 5),
		];
	}

	/**
	 * Compose the parent via the association instead of a dangling FK id in
	 * definition() (strict-definition rule).
	 *
	 * @return static
	 */
	protected function configure(): static {
		return $this->with('Users');
	}

}
