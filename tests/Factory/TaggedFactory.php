<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;

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
