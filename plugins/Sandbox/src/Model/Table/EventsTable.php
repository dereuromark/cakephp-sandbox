<?php
namespace Sandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Events Model
 *
 * @method \Sandbox\Model\Entity\Event get($primaryKey, $options = [])
 * @method \Sandbox\Model\Entity\Event newEntity($data = null, array $options = [])
 * @method \Sandbox\Model\Entity\Event[] newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\Event|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sandbox\Model\Entity\Event patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\Event[] patchEntities($entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\Event findOrCreate($search, callable $callback = null, $options = [])
 */
class EventsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->table('events');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->addBehavior('Calendar.Calendar', [
			'field' => 'beginning'
		]);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator
			->integer('id')
			->allowEmpty('id', 'create');

		$validator
			->requirePresence('title', 'create')
			->notEmpty('title');

		$validator
			->allowEmpty('location');

		$validator
			->numeric('lat')
			->allowEmpty('lat');

		$validator
			->numeric('lng')
			->allowEmpty('lng');

		$validator
			->allowEmpty('description');

		$validator
			->dateTime('beginning')
			->allowEmpty('beginning');

		$validator
			->dateTime('end')
			->allowEmpty('end');

		return $validator;
	}

}
