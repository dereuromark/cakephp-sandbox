<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * BouncerRecordFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Bouncer\Model\Entity\BouncerRecord>
 */
class BouncerRecordFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Bouncer.BouncerRecords';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'source' => 'Sandbox.SandboxArticles',
				'user_id' => 1,
				'status' => 'pending',
				'data' => '[]',
			];
		});
	}

}
