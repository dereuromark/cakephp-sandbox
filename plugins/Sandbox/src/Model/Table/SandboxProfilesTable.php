<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use Cake\Validation\Validator;
use Tools\Model\Table\Table;

/**
 * SandboxProfiles Model
 *
 * @method \Sandbox\Model\Entity\SandboxProfile newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxProfile newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxProfile> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxProfile findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile patchEntity(\Sandbox\Model\Entity\SandboxProfile $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxProfile> patchEntities(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile|false save(\Sandbox\Model\Entity\SandboxProfile $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile saveOrFail(\Sandbox\Model\Entity\SandboxProfile $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxProfile>|false saveMany(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxProfile> saveManyOrFail(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxProfile>|false deleteMany(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxProfile> deleteManyOrFail(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array $options = [])
 * @method \Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxProfile> find(string $type = 'all', mixed ...$args)
 * @method bool delete(\Sandbox\Model\Entity\SandboxProfile $entity, array $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\SandboxProfile $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile|array<\Sandbox\Model\Entity\SandboxProfile> loadInto(\Sandbox\Model\Entity\SandboxProfile|array<\Sandbox\Model\Entity\SandboxProfile> $entities, array $contain)
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
	public function validationDefault(Validator $validator): Validator {
		$validator
			->requirePresence('username', 'create')
			->notBlank('username', 'Mandatory');

		return $validator;
	}

}
