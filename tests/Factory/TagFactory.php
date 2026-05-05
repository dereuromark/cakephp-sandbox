<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * TagFactory
 *
 * @method \Cake\Datasource\EntityInterface getEntity()
 * @method array<\Cake\Datasource\EntityInterface> getEntities()
 * @method \Cake\Datasource\EntityInterface|array<\Cake\Datasource\EntityInterface> persist()
 */
class TagFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Tags.Tags';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			$label = $generator->unique()->word();

			return [
				'slug' => strtolower($label),
				'label' => $label,
				'counter' => 0,
			];
		});
	}

}
