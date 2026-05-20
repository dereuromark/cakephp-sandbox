<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use ArrayObject;
use Cake\Database\Driver\Mysql;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SandboxCities Model
 *
 * @property \Data\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 * @method \Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxCity> find(string $type = 'all', mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxCity findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCity patchEntity(\Sandbox\Model\Entity\SandboxCity $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxCity> patchEntities(iterable<\Sandbox\Model\Entity\SandboxCity> $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCity|false save(\Sandbox\Model\Entity\SandboxCity $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCity saveOrFail(\Sandbox\Model\Entity\SandboxCity $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCity>|false saveMany(iterable<\Sandbox\Model\Entity\SandboxCity> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCity> saveManyOrFail(iterable<\Sandbox\Model\Entity\SandboxCity> $entities, array $options = [])
 * @method bool delete(\Sandbox\Model\Entity\SandboxCity $entity, array $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\SandboxCity $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCity>|false deleteMany(iterable<\Sandbox\Model\Entity\SandboxCity> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxCity> deleteManyOrFail(iterable<\Sandbox\Model\Entity\SandboxCity> $entities, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCity|array<\Sandbox\Model\Entity\SandboxCity> loadInto(\Sandbox\Model\Entity\SandboxCity|array<\Sandbox\Model\Entity\SandboxCity> $entities, array $contain)
 * @extends \Cake\ORM\Table<array{}, \Sandbox\Model\Entity\SandboxCity>
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

	/**
	 * Sync coordinates POINT column from lat/lng before save.
	 *
	 * This replaces MySQL triggers which require SUPER privilege with binary logging.
	 * Only runs on MySQL as spatial functions are not available on SQLite/Postgres.
	 *
	 * @param \Cake\Event\EventInterface $event The event.
	 * @param \Sandbox\Model\Entity\SandboxCity $entity The entity.
	 * @param \ArrayObject $options Options.
	 * @return void
	 */
	public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void {
		$connection = $this->getConnection();
		if (!$connection->getDriver() instanceof Mysql) {
			return;
		}

		if ($entity->isDirty('lat') || $entity->isDirty('lng') || $entity->isNew()) {
			$lat = $entity->get('lat');
			$lng = $entity->get('lng');
			if ($lat !== null && $lng !== null) {
				$point = $connection->execute(
					"SELECT ST_GeomFromText(CONCAT('POINT(', ?, ' ', ?, ')')) AS point",
					[$lng, $lat],
				)->fetchColumn(0);
				$entity->set('coordinates', $point);
			}
		}
	}

}
