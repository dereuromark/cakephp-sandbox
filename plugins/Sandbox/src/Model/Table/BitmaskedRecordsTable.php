<?php
declare(strict_types = 1);

namespace Sandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BitmaskedRecords Model
 *
 * @method \Sandbox\Model\Entity\BitmaskedRecord newEmptyEntity()
 * @method \Sandbox\Model\Entity\BitmaskedRecord newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\BitmaskedRecord> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\BitmaskedRecord get($primaryKey, $options = [])
 * @method \Sandbox\Model\Entity\BitmaskedRecord findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Sandbox\Model\Entity\BitmaskedRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\BitmaskedRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\BitmaskedRecord|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sandbox\Model\Entity\BitmaskedRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\BitmaskedRecord>|false saveMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\BitmaskedRecord> saveManyOrFail(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\BitmaskedRecord>|false deleteMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\BitmaskedRecord> deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class BitmaskedRecordsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('bitmasked_records');
		$this->setDisplayField('name');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Search.Search');

		$this->searchManager()
			->finder('flags', ['fields' => ['flag_required'], 'finder' => 'bits', 'map' => ['bits' => 'flags']]);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->integer('id')
			->allowEmptyString('id', null, 'create');

		$validator
			->scalar('name')
			->maxLength('name', 100)
			->requirePresence('name', 'create')
			->notEmptyString('name');

		$validator
			->integer('flag_optional')
			->allowEmptyString('flag_optional');

		$validator
			->integer('flag_required')
			->notEmptyString('flag_required');

		return $validator;
	}

}
