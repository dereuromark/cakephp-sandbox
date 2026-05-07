<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * TaggedFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Tags\Model\Entity\Tagged>
 */
class TaggedFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Tags.Tagged';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'tag_id' => 1,
			'fk_id' => 1,
			'fk_table' => 'sandbox_posts',
		];
	}

}
