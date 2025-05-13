<?php
declare(strict_types=1);

namespace StateMachineSandbox\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use StateMachine\Business\StateMachineFacade;
use StateMachine\Dto\StateMachine\ProcessDto;
use StateMachineSandbox\StateMachine\RegistrationStateMachineHandler;

/**
 * Registrations Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \StateMachineSandbox\Model\Entity\Registration newEmptyEntity()
 * @method \StateMachineSandbox\Model\Entity\Registration newEntity(array $data, array $options = [])
 * @method array<\StateMachineSandbox\Model\Entity\Registration> newEntities(array $data, array $options = [])
 * @method \StateMachineSandbox\Model\Entity\Registration get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \StateMachineSandbox\Model\Entity\Registration findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \StateMachineSandbox\Model\Entity\Registration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\StateMachineSandbox\Model\Entity\Registration> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \StateMachineSandbox\Model\Entity\Registration|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \StateMachineSandbox\Model\Entity\Registration saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\StateMachineSandbox\Model\Entity\Registration>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\StateMachineSandbox\Model\Entity\Registration> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\StateMachineSandbox\Model\Entity\Registration>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\StateMachineSandbox\Model\Entity\Registration> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @property \StateMachine\Model\Table\StateMachineItemsTable&\Cake\ORM\Association\HasOne $RegistrationStates
 * @extends \Cake\ORM\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior}>
 */
class RegistrationsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('registrations');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'joinType' => 'INNER',
			'className' => 'Users',
		]);
		$this->hasOne('RegistrationStates', [
			'className' => 'StateMachine.StateMachineItems',
			'foreignKey' => 'identifier',
			'conditions' => ['RegistrationStates.state_machine' => 'Registration'],
			'dependent' => true,
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
			->integer('id')
			->allowEmptyString('id', null, 'create');

		$validator
			->scalar('status')
			->maxLength('status', 100)
			->notEmptyString('status');

		$validator
			->add('user_id', 'unique', [
				'rule' => [
					'validateUnique', ['scope' => ['session_id']],
				],
				'message' => 'There is already a registration open for this user, please complete or cancel that one first.',
				'provider' => 'table',
			]);

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
		$rules->add($rules->existsIn(['user_id'], 'Users'));

		return $rules;
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \StateMachineSandbox\Model\Entity\Registration $entity
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void {
		// For testing/demo only (so multiple users have the same experience)
		if (PHP_SAPI === 'cli' && $entity->session_id === null) {
			$entity->session_id = 'cli_demo';
		}
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @param \StateMachineSandbox\Model\Entity\Registration $entity
	 * @param \ArrayObject $options
	 * @return void
	 */
	public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void {
		$stateMachineFacade = new StateMachineFacade();
		$processDto = new ProcessDto();
		$processDto->setStateMachineName(RegistrationStateMachineHandler::NAME);

		$identifier = $entity->id;

		// For testing we dont actually trigger it for now
		if (PHP_SAPI !== 'cli' || $entity->session_id === 'cli_demo') {
			$stateMachineFacade->triggerForNewStateMachineItem($processDto, $identifier);
		}
	}

}
