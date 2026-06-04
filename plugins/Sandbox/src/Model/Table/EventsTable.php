<?php

namespace Sandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Events Model
 *
 * @extends \Cake\ORM\Table<array{Calendar: \Calendar\Model\Behavior\CalendarBehavior}, \Sandbox\Model\Entity\Event>
 * @method \Sandbox\Model\Entity\Event patchEntity(\Sandbox\Model\Entity\Event $entity, array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\Sandbox\Model\Entity\Event> patchEntities(iterable<\Sandbox\Model\Entity\Event> $entities, array<mixed> $data, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\Event|false save(\Sandbox\Model\Entity\Event $entity, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\Event saveOrFail(\Sandbox\Model\Entity\Event $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\Event>|false saveMany(iterable<\Sandbox\Model\Entity\Event> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\Event> saveManyOrFail(iterable<\Sandbox\Model\Entity\Event> $entities, array<string, mixed> $options = [])
 * @method bool delete(\Sandbox\Model\Entity\Event $entity, array<string, mixed> $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\Event $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\Event>|false deleteMany(iterable<\Sandbox\Model\Entity\Event> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\Event> deleteManyOrFail(iterable<\Sandbox\Model\Entity\Event> $entities, array<string, mixed> $options = [])
 * @mixin \Calendar\Model\Behavior\CalendarBehavior
 */
class EventsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('events');
		$this->setDisplayField('title');

		$this->addBehavior('Calendar.Calendar', [
			'field' => 'beginning',
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
			->requirePresence('title', 'create')
			->notEmptyString('title');

		$validator
			->allowEmptyString('location');

		$validator
			->numeric('lat')
			->allowEmptyString('lat');

		$validator
			->numeric('lng')
			->allowEmptyString('lng');

		$validator
			->allowEmptyString('description');

		$validator
			->dateTime('beginning')
			->allowEmptyDateTime('beginning');

		$validator
			->dateTime('end')
			->allowEmptyDateTime('end');

		return $validator;
	}

}
