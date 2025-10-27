<?php

namespace Sandbox\Model\Table;

use Cake\Database\Type\EnumType;
use Cake\Validation\Validator;
use Sandbox\Model\Enum\UserStatus;
use Tools\Model\Table\Table;

/**
 * @method \Sandbox\Model\Entity\SandboxUser newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxUser newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxUser> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxUser get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxUser findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxUser> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxUser|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxUser saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxUser>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxUser> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxUser>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxUser> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SandboxUsersTable extends Table {

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->getSchema()->setColumnType('status', EnumType::from(UserStatus::class));

		$this->setDisplayField('username');
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->requirePresence('username', 'create')
			->notBlank('username', 'Mandatory');

		$validator
			->requirePresence('email', 'create')
			->email('email', false, 'Email invalid');

		return $validator;
	}

}
