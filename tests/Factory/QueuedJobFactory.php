<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

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
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'job_task' => 'Example',
		];
	}

}
