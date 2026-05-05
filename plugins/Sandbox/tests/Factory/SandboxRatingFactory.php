<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxRatingFactory
 *
 * @method \Sandbox\Model\Entity\SandboxRating getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxRating> getEntities()
 * @method \Sandbox\Model\Entity\SandboxRating|array<\Sandbox\Model\Entity\SandboxRating> persist()
 */
class SandboxRatingFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxRatings';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'user_id' => 1,
				'foreign_key' => 1,
				'model' => 'Posts',
				'value' => $generator->numberBetween(1, 5),
			];
		});
	}

}
