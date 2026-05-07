<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * DocumentFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\WorkflowSandbox\Model\Entity\Document>
 */
class DocumentFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Documents';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'title' => $generator->sentence(3),
			'status' => 'draft',
			'current_approver_level' => 0,
		];
	}

}
