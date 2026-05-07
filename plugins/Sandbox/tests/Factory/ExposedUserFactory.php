<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * ExposedUserFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Sandbox\Model\Entity\ExposedUser>
 */
class ExposedUserFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.ExposedUsers';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'name' => $generator->name(),
			'uuid' => $generator->unique()->uuid(),
		];
	}

}
