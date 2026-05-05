<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxCategoryFactory
 *
 * @method \Sandbox\Model\Entity\SandboxCategory getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxCategory> getEntities()
 * @method \Sandbox\Model\Entity\SandboxCategory|array<\Sandbox\Model\Entity\SandboxCategory> persist()
 */
class SandboxCategoryFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxCategories';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'name' => $generator->word(),
				'description' => $generator->sentence(),
				'status' => 1,
				'lft' => 1,
				'rght' => 2,
			];
		});
	}

}
