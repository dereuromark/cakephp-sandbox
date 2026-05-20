<?php

namespace Sandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Events Model
 *
 * @extends \Cake\ORM\Table<array{Calendar: \Calendar\Model\Behavior\CalendarBehavior}, \Sandbox\Model\Entity\Event>
 * @method \Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\Event> find(string $type = 'all', mixed ...$args)
 * @method \Sandbox\Model\Entity\Event findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\Event patchEntity(\Sandbox\Model\Entity\Event $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\Event> patchEntities(iterable<\Sandbox\Model\Entity\Event> $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\Event|false save(\Sandbox\Model\Entity\Event $entity, array $options = [])
 * @method \Sandbox\Model\Entity\Event saveOrFail(\Sandbox\Model\Entity\Event $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Event>|false saveMany(iterable<\Sandbox\Model\Entity\Event> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Event> saveManyOrFail(iterable<\Sandbox\Model\Entity\Event> $entities, array $options = [])
 * @method bool delete(\Sandbox\Model\Entity\Event $entity, array $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\Event $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Event>|false deleteMany(iterable<\Sandbox\Model\Entity\Event> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Event> deleteManyOrFail(iterable<\Sandbox\Model\Entity\Event> $entities, array $options = [])
 * @method \Sandbox\Model\Entity\Event|array<\Sandbox\Model\Entity\Event> loadInto(\Sandbox\Model\Entity\Event|array<\Sandbox\Model\Entity\Event> $entities, array $contain)
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
