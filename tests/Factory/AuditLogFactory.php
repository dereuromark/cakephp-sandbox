<?php
declare(strict_types=1);

namespace App\Test\Factory;

use AuditStash\AuditLogType;
use CakephpFixtureFactories\Factory\BaseFactory;
use CakephpFixtureFactories\Generator\GeneratorInterface;

/**
 * AuditLogFactory
 *
 * @extends \CakephpFixtureFactories\Factory\BaseFactory<\AuditStash\Model\Entity\AuditLog>
 */
class AuditLogFactory extends BaseFactory {

	/**
	 * @return string
	 */
	protected function getRootTableRegistryName(): string {
		return 'AuditStash.AuditLogs';
	}

	/**
	 * @param \CakephpFixtureFactories\Generator\GeneratorInterface $generator Generator
	 *
	 * @return array<string, mixed>
	 */
	public function definition(GeneratorInterface $generator): array {
		return [
			'transaction_key' => $generator->unique()->uuid(),
			'type' => AuditLogType::Update->value,
			'primary_key' => 1,
			'source' => 'Sandbox.SandboxArticles',
			'original' => '{}',
			'changed' => '{}',
		];
	}

}
