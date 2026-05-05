<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;
use Sandbox\Model\Enum\UserStatus;

/**
 * SandboxUserFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Sandbox\Model\Entity\SandboxUser>
 */
class SandboxUserFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxUsers';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		$username = $generator->unique()->userName();

		return [
			'username' => $username,
			'slug' => strtolower($username),
			'password' => $generator->sha256(),
			'email' => $generator->unique()->safeEmail(),
			'role_id' => 4,
			'status' => UserStatus::Active,
		];
	}

}
