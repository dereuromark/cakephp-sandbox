<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * ContentFactory
 *
 * @method \WorkflowSandbox\Model\Entity\Content getEntity()
 * @method array<\WorkflowSandbox\Model\Entity\Content> getEntities()
 * @method \WorkflowSandbox\Model\Entity\Content|array<\WorkflowSandbox\Model\Entity\Content> persist()
 */
class ContentFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Contents';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'title' => $generator->sentence(3),
				'body' => $generator->paragraph(2),
				'status' => 'draft',
			];
		});
	}

}
