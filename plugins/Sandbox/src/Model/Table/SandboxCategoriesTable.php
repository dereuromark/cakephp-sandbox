<?php

namespace Sandbox\Model\Table;

use Cake\Validation\Validator;
use Tools\Model\Table\Table;

/**
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 * @method \Sandbox\Model\Entity\SandboxCategory get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxCategory newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxCategory> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxCategory> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCategory>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCategory> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCategory>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCategory> deleteManyOrFail(iterable $entities, array $options = [])
 * @extends \Tools\Model\Table\Table<array{Tree: \Cake\ORM\Behavior\TreeBehavior}>
 */
class SandboxCategoriesTable extends Table {

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->addBehavior('Tree');
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->requirePresence('name', 'create')
			->notBlank('name', 'Mandatory');

		return $validator;
	}

}
