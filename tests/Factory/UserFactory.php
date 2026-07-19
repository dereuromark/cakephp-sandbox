<?php
declare(strict_types=1);

namespace App\Test\Factory;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * UserFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\App\Model\Entity\User>
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
	 * Cache the bcrypt hash for the default plaintext password '123'.
	 *
	 * Why: bcrypt at cost 10 takes ~80ms, and most tests create a user just for
	 * session(['Auth' => ...]) and never verify the password. Hashing once across
	 * the suite saves seconds. Login-POST tests still verify because the cached
	 * hash matches the same plaintext '123'.
	 *
	 * @var string|null
	 */
	private static ?string $defaultPasswordHash = null;

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Users';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'username' => $generator->unique()->userName(),
			'email' => $generator->unique()->safeEmail(),
			'password' => static::$defaultPasswordHash ??= (new DefaultPasswordHasher())->hash('123'),
			'active' => true,
			'logins' => 0,
		];
	}

	/**
	 * The default role rides as a configure()-state, not in definition():
	 * role ids point at the seeded static roles rows, and the strict
	 * definition detector flags FK columns in definition() output. A state
	 * keeps asAdmin()/asMod()/call-site overrides working unchanged.
	 *
	 * @return static
	 */
	protected function configure(): static {
		return $this->state(['role_id' => static::ROLE_USER]);
	}

	/**
	 * @return $this
	 */
	public function asAdmin() {
		return $this->state(['role_id' => static::ROLE_ADMIN]);
	}

	/**
	 * @return $this
	 */
	public function asSuperadmin() {
		return $this->state(['role_id' => static::ROLE_SUPERADMIN]);
	}

	/**
	 * @return $this
	 */
	public function asMod() {
		return $this->state(['role_id' => static::ROLE_MOD]);
	}

}
