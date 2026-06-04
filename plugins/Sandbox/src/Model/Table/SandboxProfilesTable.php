<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use Cake\Validation\Validator;
use Tools\Model\Table\Table;

/**
 * SandboxProfiles Model
 *
 * @extends \Tools\Model\Table\Table<array{}, \Sandbox\Model\Entity\SandboxProfile>
 * @method \Sandbox\Model\Entity\SandboxProfile newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxProfile newEntity(array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxProfile> newEntities(array<mixed> $data, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile get(mixed $primaryKey, array<string, mixed>|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxProfile> find(string $type = 'all', mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxProfile findOrCreate(\Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxProfile>|callable|array<string, mixed> $search, ?callable $callback = null, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile patchEntity(\Sandbox\Model\Entity\SandboxProfile $entity, array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxProfile> patchEntities(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array<mixed> $data, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile|false save(\Sandbox\Model\Entity\SandboxProfile $entity, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile saveOrFail(\Sandbox\Model\Entity\SandboxProfile $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\SandboxProfile>|false saveMany(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\SandboxProfile> saveManyOrFail(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array<string, mixed> $options = [])
 * @method bool delete(\Sandbox\Model\Entity\SandboxProfile $entity, array<string, mixed> $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\SandboxProfile $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\SandboxProfile>|false deleteMany(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\SandboxProfile> deleteManyOrFail(iterable<\Sandbox\Model\Entity\SandboxProfile> $entities, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\SandboxProfile|array<\Sandbox\Model\Entity\SandboxProfile> loadInto(\Sandbox\Model\Entity\SandboxProfile|array<\Sandbox\Model\Entity\SandboxProfile> $entities, array<mixed> $contain)
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
