<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * QueueProcessFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Queue\Model\Entity\QueueProcess>
 */
class QueueProcessFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Queue.QueueProcesses';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'pid' => (string)$generator->numberBetween(1000, 99999),
				'terminate' => false,
				'workerkey' => $generator->unique()->uuid(),
			];
		});
	}

}
