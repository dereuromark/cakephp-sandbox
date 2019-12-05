<?php

namespace Sandbox\Model\Table;

use App\Model\Entity\Entity;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Tools\Model\Table\Table;

class AnimalsTable extends Table {

	/**
	 * @var array
	 */
	public $order = ['name' => 'ASC'];

	/**
	 * @var array
	 */
	public $filterArgs = [
		'search' => ['type' => 'like', 'field' => ['name']],
	];

	/**
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config) {
		$this->setTable('sandbox_animals');

		//$this->addBehavior('Search.Searchable');
		parent::initialize($config);
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('name', 'alphanumeric', [
				'rule' => 'alphanumeric',
				'message' => __('You need to provide a name, only alphanumeric chars are allowed.'),
				//'provider' => 'table',
				'requirePresence' => true,
				'allowEmpty' => false,
				'last' => true,
			])
			->add('name', [
				'unique' => ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'This animal already exists!'],
			])
			->add('confirm', 'notEmpty', [
				'rule' => function ($value, $context) {
					return !empty($value);
				},
				'message' => __('Please select checkbox to continue.'),
				//'provider' => 'table',
				'requirePresence' => true,
				'allowEmpty' => false,
				'last' => true,
			]);
		return $validator;
	}

	/**
	 * @param \Cake\ORM\RulesChecker $rules
	 *
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules) {
		// Add a rule that is applied for create and update operations
		$rules->add(function (Entity $entity, $options) {
			if ($entity->get('name') !== 'Mouse' && $entity->get('name') !== 'Cat') {
				return false;
			}
			return true;
		});

		return $rules;
	}

}
