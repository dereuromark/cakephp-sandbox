<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Enum\AuditLogType;
use Cake\Database\Type\EnumType;
use Cake\ORM\Table;

/**
 * AuditLogs Model
 *
 * @method \App\Model\Entity\AuditLog newEmptyEntity()
 * @method \App\Model\Entity\AuditLog newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AuditLog> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AuditLog get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AuditLog findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AuditLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AuditLog> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AuditLog|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AuditLog saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AuditLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditLog>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditLog> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditLog>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AuditLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AuditLog> deleteManyOrFail(iterable $entities, array $options = [])
 */
class AuditLogsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('audit_logs');
		$this->setDisplayField('display_value');
		$this->setPrimaryKey('id');
		$this->setEntityClass('App\Model\Entity\AuditLog');

		$this->getSchema()->setColumnType('type', EnumType::from(AuditLogType::class));
	}

}
