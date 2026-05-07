<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * SandboxArticleFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Sandbox\Model\Entity\SandboxArticle>
 */
class SandboxArticleFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.SandboxArticles';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'title' => $generator->sentence(4),
			'content' => $generator->paragraph(3),
			'status' => 'published',
			'user_id' => 1,
		];
	}

}
