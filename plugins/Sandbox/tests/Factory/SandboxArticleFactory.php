<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxArticleFactory
 *
 * @method \Sandbox\Model\Entity\SandboxArticle getEntity()
 * @method array<\Sandbox\Model\Entity\SandboxArticle> getEntities()
 * @method \Sandbox\Model\Entity\SandboxArticle|array<\Sandbox\Model\Entity\SandboxArticle> persist()
 */
class SandboxArticleFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxArticles';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'title' => $generator->sentence(4),
				'content' => $generator->paragraph(3),
				'status' => 'published',
				'user_id' => 1,
			];
		});
	}

}
