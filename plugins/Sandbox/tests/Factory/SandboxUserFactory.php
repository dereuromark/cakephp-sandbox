<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;
use Sandbox\Model\Enum\UserStatus;

/**
 * SandboxUserFactory
 *
 * @method \Sandbox\Model\Entity\SandboxUser getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxUser> getEntities()
 * @method \Sandbox\Model\Entity\SandboxUser|array<\Sandbox\Model\Entity\SandboxUser> persist()
 */
class SandboxUserFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxUsers';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			$username = $generator->unique()->userName();

			return [
				'username' => $username,
				'slug' => strtolower($username),
				'password' => $generator->sha256(),
				'email' => $generator->unique()->safeEmail(),
				'role_id' => 4,
				'status' => UserStatus::Active,
			];
		});
	}

}
