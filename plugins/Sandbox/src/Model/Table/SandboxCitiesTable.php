<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SandboxCities Model
 *
 * @property \Data\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 *
 * @method \Sandbox\Model\Entity\SandboxCity newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxCity newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxCity> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCity get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxCity findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxCity> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCity|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCity saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCity>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCity> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCity>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCity> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SandboxCitiesTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('sandbox_cities');
		$this->setDisplayField('name');
		$this->setPrimaryKey('id');

		$this->belongsTo('Countries', [
			'foreignKey' => 'country_id',
			'joinType' => 'INNER',
			'className' => 'Data.Countries',
		]);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('name')
			->maxLength('name', 190)
			->requirePresence('name', 'create')
			->notEmptyString('name');

		$validator
			->scalar('alias')
			->maxLength('alias', 190)
			->allowEmptyString('alias');

		$validator
			->nonNegativeInteger('country_id')
			->notEmptyString('country_id');

		$validator
			->numeric('lat')
			->requirePresence('lat', 'create')
			->notEmptyString('lat');

		$validator
			->numeric('lng')
			->requirePresence('lng', 'create')
			->notEmptyString('lng');

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
		$rules->add($rules->isUnique(['name', 'country_id']), ['errorField' => 'name']);
		$rules->add($rules->existsIn(['country_id'], 'Countries'), ['errorField' => 'country_id']);

		return $rules;
	}

}
