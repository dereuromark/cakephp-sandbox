<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * TagFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Tags\Model\Entity\Tag>
 */
class TagFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Tags.Tags';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		$label = $generator->unique()->word();

		return [
			'slug' => strtolower($label),
			'label' => $label,
			'counter' => 0,
		];
	}

}
