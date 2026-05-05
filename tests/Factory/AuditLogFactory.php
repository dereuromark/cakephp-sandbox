<?php
declare(strict_types=1);

namespace App\Test\Factory;

use AuditStash\AuditLogType;
use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * AuditLogFactory
 *
 * @method \Cake\Datasource\EntityInterface getEntity()
 * @method array<\Cake\Datasource\EntityInterface> getEntities()
 * @method \Cake\Datasource\EntityInterface|array<\Cake\Datasource\EntityInterface> persist()
 */
class AuditLogFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'AuditStash.AuditLogs';
	}

	/**
	 * @return void
	 */
	protected function setDefaultTemplate(): void {
		$this->setDefaultData(function (GeneratorInterface $generator): array {
			return [
				'transaction_key' => $generator->unique()->uuid(),
				'type' => AuditLogType::Update->value,
				'primary_key' => 1,
				'source' => 'Sandbox.SandboxArticles',
				'original' => '{}',
				'changed' => '{}',
			];
		});
	}

}
