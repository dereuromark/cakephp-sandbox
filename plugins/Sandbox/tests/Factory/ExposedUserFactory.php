<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * ExposedUserFactory
 *
 * @method \Sandbox\Model\Entity\ExposedUser getEntity()
 * @method array<\Sandbox\Model\Entity\ExposedUser> getEntities()
 * @method \Sandbox\Model\Entity\ExposedUser|array<\Sandbox\Model\Entity\ExposedUser> persist()
 */
class ExposedUserFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.ExposedUsers';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'name' => $generator->name(),
				'uuid' => $generator->unique()->uuid(),
			];
		});
	}

}
