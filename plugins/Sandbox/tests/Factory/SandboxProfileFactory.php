<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxProfileFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Sandbox\Model\Entity\SandboxProfile>
 */
class SandboxProfileFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxProfiles';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'username' => $generator->unique()->userName(),
			'balance' => $generator->randomFloat(2, 0, 1000),
			'extra' => $generator->randomFloat(2, 0, 100),
		];
	}

}
