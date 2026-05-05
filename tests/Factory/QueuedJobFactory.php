<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;

/**
 * QueuedJobFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\Queue\Model\Entity\QueuedJob>
 */
class QueuedJobFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'Queue.QueuedJobs';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(fn (): array => [
			'job_task' => 'Example',
		]);
	}

}
