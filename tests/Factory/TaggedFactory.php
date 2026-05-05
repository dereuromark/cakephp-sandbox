<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;

/**
 * TaggedFactory
 *
 * @method \Cake\Datasource\EntityInterface getEntity()
 * @method array<\Cake\Datasource\EntityInterface> getEntities()
 * @method \Cake\Datasource\EntityInterface|array<\Cake\Datasource\EntityInterface> persist()
 */
class TaggedFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Tags.Tagged';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(fn (): array => [
			'tag_id' => 1,
			'fk_id' => 1,
			'fk_table' => 'sandbox_posts',
		]);
	}

}
