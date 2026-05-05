<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;

/**
 * FavoriteFactory
 *
 * @method \Cake\Datasource\EntityInterface getEntity()
 * @method array<\Cake\Datasource\EntityInterface> getEntities()
 * @method \Cake\Datasource\EntityInterface|array<\Cake\Datasource\EntityInterface> persist()
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
