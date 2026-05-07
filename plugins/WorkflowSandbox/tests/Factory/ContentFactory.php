<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * ContentFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\WorkflowSandbox\Model\Entity\Content>
 */
class ContentFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Contents';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'title' => $generator->sentence(3),
			'body' => $generator->paragraph(2),
			'status' => 'draft',
		];
	}

}
