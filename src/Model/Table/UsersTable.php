<?php
namespace App\Model\Table;

use Tools\Model\Table\Table;

/**
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 *
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 */
class UsersTable extends Table {

	/**
	 * @var string
	 */
	public $displayField = 'username';

	/**
	 * @var array
	 */
	public $validate = [
		'username' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true
			],
			'isUnique' => [
				'rule' => 'validateUnique',
				'message' => 'Username already exists',
				'last' => true,
				'provider' => 'table'
			],
		],
		'email' => [
			'email' => [
				'rule' => ['email'],
				'message' => 'Email invalid',
				'last' => true
			],
			'unique' => [
				'rule' => ['validateUnique'],
				'message' => 'Email already exists',
				'last' => true,
				'provider' => 'table'
			],
		],
	];

	/**
	 * @param array $config
	 *
	 * @return void
	 */
	public function initialize(array $config) {
		$this->belongsTo('Roles');

		$this->displayField('username');

		$this->addBehavior('Timestamp');
	}

}
