<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * DocumentFactory
 *
 * @method \WorkflowSandbox\Model\Entity\Document getEntity()
 * @method array<\WorkflowSandbox\Model\Entity\Document> getEntities()
 * @method \WorkflowSandbox\Model\Entity\Document|array<\WorkflowSandbox\Model\Entity\Document> persist()
 */
class DocumentFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'WorkflowSandbox.Documents';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'title' => $generator->sentence(3),
				'status' => 'draft',
				'current_approver_level' => 0,
			];
		});
	}

}
