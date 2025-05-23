<?php
declare(strict_types = 1);

namespace Sandbox\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Tools\Model\Table\Table;

/**
 * ExposedUsers Model
 *
 * @method \Sandbox\Model\Entity\ExposedUser newEmptyEntity()
 * @method \Sandbox\Model\Entity\ExposedUser newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\ExposedUser> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\ExposedUser get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\ExposedUser findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\ExposedUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\ExposedUser> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\ExposedUser|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\ExposedUser saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\ExposedUser>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\ExposedUser> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\ExposedUser>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\ExposedUser> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Expose\Model\Behavior\ExposeBehavior
 * @extends \Tools\Model\Table\Table<array{Expose: \Expose\Model\Behavior\ExposeBehavior, Timestamp: \Cake\ORM\Behavior\TimestampBehavior}>
 */
class ExposedUsersTable extends Table {

	/**
	 * @var array<int|string, mixed>
	 */
	protected array $order = [
		'name' => 'ASC',
	];

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('exposed_users');
		$this->setDisplayField('name');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Expose.Expose');
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->add('some_field', 'valid', [
				'rule' => 'alphanumeric',
				'message' => __('Only alphanumeric chars are allowed.'),
			]);

		return $validator;
	}

	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules): RulesChecker {
		// We do this using DB constraint.
		//$rules->add($rules->isUnique(['uuid']));

		return $rules;
	}

}
