<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * FavoriteFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Favorites\Model\Entity\Favorite>
 */
class FavoriteFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Favorites.Favorites';
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
			'user_id' => 1,
			'value' => 1,
		];
	}

}
