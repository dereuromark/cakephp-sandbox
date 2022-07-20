<?php

namespace Sandbox\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Tools\Model\Table\Table;

class AnimalsTable extends Table {

	/**
	 * @var array<int|string, mixed>|string|null
	 */
	protected $order = ['name' => 'ASC'];

	/**
	 * @param array<string, mixed> $config
	 * @return void
	 */
	public function initialize(array $config): void {
		$this->setTable('sandbox_animals');

		parent::initialize($config);
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
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
	public function buildRules(RulesChecker $rules): RulesChecker {
		// Add a rule that is applied for create and update operations
		$rules->add(function (EntityInterface $entity, $options) {
			$name = $entity->get('name');
			if ($name !== 'Mouse' && $name !== 'Cat') {
				return false;
			}

			return true;
		});

		return $rules;
	}

}
