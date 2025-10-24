<?php

namespace Sandbox\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Country search form with validation
 */
class CountrySearchForm extends Form {

	/**
	 * Build the form schema
	 *
	 * @param \Cake\Form\Schema $schema
	 *
	 * @return \Cake\Form\Schema
	 */
	protected function _buildSchema(Schema $schema): Schema {
		return $schema
			->addField('search', ['type' => 'string'])
			->addField('status', ['type' => 'string']);
	}

	/**
	 * Build the validator
	 *
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->allowEmptyString('search')
			->minLength('search', 3, 'Search term must be at least 3 characters long');

		$callable = function ($value, $context) {
			if ($value === '' || $value === null) {
				return true;
			}
			// Fake validation: Only "active" status is valid
			if ($value !== '1') {
				return false;
			}

			return true;
		};

		$validator
			->allowEmptyString('status')
			->add('status', 'activeOnlyToday', [
				'rule' => $callable,
				'message' => 'You can only search for active ones today, sry!',
			]);

		return $validator;
	}

	/**
	 * Execute the form (not used for search)
	 *
	 * @param array<string, mixed> $data
	 *
	 * @return bool
	 */
	protected function _execute(array $data): bool {
		return true;
	}

}
