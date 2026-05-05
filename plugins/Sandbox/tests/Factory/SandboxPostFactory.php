<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxPostFactory
 *
 * @method \Sandbox\Model\Entity\SandboxPost getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxPost> getEntities()
 * @method \Sandbox\Model\Entity\SandboxPost|array<\Sandbox\Model\Entity\SandboxPost> persist()
 */
class SandboxPostFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxPosts';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'title' => $generator->sentence(4),
				'content' => $generator->paragraph(2),
				'rating_count' => 0,
				'rating_sum' => 0,
			];
		});
	}

}
