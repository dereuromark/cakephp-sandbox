<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

/**
 * SandboxProfiles Model
 *
 * @method \Sandbox\Model\Entity\SandboxProfile newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxProfile newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxProfile> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxProfile findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxProfile> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxProfile>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxProfile> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxProfile>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxProfile> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SandboxProfilesTable extends Table {

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('sandbox_profiles');
		$this->setDisplayField('username');
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(\Cake\Validation\Validator $validator): \Cake\Validation\Validator {
		$validator
			->requirePresence('username', 'create')
			->notBlank('username', 'Mandatory');

		return $validator;
	}

}
