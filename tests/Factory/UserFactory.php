<?php
declare(strict_types=1);

namespace App\Test\Factory;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * UserFactory
 *
 * @method \App\Model\Entity\User getEntity()
 * @method array<\App\Model\Entity\User> getEntities()
 * @method \App\Model\Entity\User|array<\App\Model\Entity\User> persist()
 * @method static \App\Model\Entity\User get(mixed $primaryKey, array $options = [])
 */
class UserFactory extends BaseFactory {

	/**
     * @var int
     */
	public const ROLE_SUPERADMIN = 1;

	/**
     * @var int
     */
	public const ROLE_ADMIN = 2;

	/**
     * @var int
     */
	public const ROLE_MOD = 3;

	/**
     * @var int
     */
	public const ROLE_USER = 4;

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Users';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'username' => $generator->unique()->userName(),
				'email' => $generator->unique()->safeEmail(),
				'password' => (new DefaultPasswordHasher())->hash('123'),
				'role_id' => static::ROLE_USER,
				'active' => true,
				'logins' => 0,
			];
		});
	}

	/**
	 * @return $this
	 */
	public function asAdmin() {
		return $this->patchData(['role_id' => static::ROLE_ADMIN]);
	}

	/**
	 * @return $this
	 */
	public function asSuperadmin() {
		return $this->patchData(['role_id' => static::ROLE_SUPERADMIN]);
	}

	/**
	 * @return $this
	 */
	public function asMod() {
		return $this->patchData(['role_id' => static::ROLE_MOD]);
	}

}
