<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * RoleFactory
 *
 * @method \App\Model\Entity\Role getEntity()
 * @method array<\App\Model\Entity\Role> getEntities()
 * @method \App\Model\Entity\Role|array<\App\Model\Entity\Role> persist()
 * @method static \App\Model\Entity\Role get(mixed $primaryKey, array $options = [])
 */
class RoleFactory extends BaseFactory {

	/**
	 * @var array<string>
	 */
	protected array $uniqueProperties = [
		'alias',
	];

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Roles';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'name' => $generator->unique()->word(),
				'alias' => $generator->unique()->word(),
			];
		});
	}

	/**
	 * Seeds the four standard roles (Superadmin, Admin, Mod, User) with stable ids 1-4.
	 *
	 * @return array<\App\Model\Entity\Role>
	 */
	public static function seedAll(): array {
		$rows = [
			['id' => 1, 'name' => 'Superadmin', 'alias' => 'superadmin'],
			['id' => 2, 'name' => 'Admin', 'alias' => 'admin'],
			['id' => 3, 'name' => 'Moderator', 'alias' => 'mod'],
			['id' => 4, 'name' => 'User', 'alias' => 'user'],
		];

		$entities = [];
		foreach ($rows as $row) {
			$entities[] = static::make($row)->persist();
		}

		return $entities;
	}

}
