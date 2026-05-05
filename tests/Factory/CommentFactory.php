<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * CommentFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Comments\Model\Entity\Comment>
 */
class CommentFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Comments.Comments';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'foreign_key' => 1,
			'model' => 'Posts',
			'content' => $generator->paragraph(2),
			'is_private' => false,
			'is_spam' => false,
		];
	}

}
