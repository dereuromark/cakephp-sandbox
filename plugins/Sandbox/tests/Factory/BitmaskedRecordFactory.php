<?php
declare(strict_types=1);

namespace Sandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * BitmaskedRecordFactory
 *
 * @method \Sandbox\Model\Entity\BitmaskedRecord getEntity()
 * @method array<\Sandbox\Model\Entity\BitmaskedRecord> getEntities()
 * @method \Sandbox\Model\Entity\BitmaskedRecord|array<\Sandbox\Model\Entity\BitmaskedRecord> persist()
 */
class BitmaskedRecordFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Sandbox.BitmaskedRecords';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'name' => $generator->word(),
				'flag_required' => 1,
			];
		});
	}

}
