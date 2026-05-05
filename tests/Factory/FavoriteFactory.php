<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;

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
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(fn (): array => [
			'foreign_key' => 1,
			'model' => 'Posts',
			'user_id' => 1,
			'value' => 1,
		]);
	}

}
