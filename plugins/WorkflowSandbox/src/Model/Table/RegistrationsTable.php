<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Registrations Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \WorkflowSandbox\Model\Entity\Registration newEmptyEntity()
 * @method \WorkflowSandbox\Model\Entity\Registration newEntity(array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Registration> newEntities(array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Registration get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \WorkflowSandbox\Model\Entity\Registration findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Registration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Registration> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Registration|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Registration saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Registration>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Registration>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Registration>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Registration> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Registration>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Registration>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Registration>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Registration> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Workflow\Model\Behavior\WorkflowBehavior
 */
class RegistrationsTable extends Table {

	/**
	 * @param array<string, mixed> $config Configuration
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('workflow_registrations');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Workflow.Workflow', [
			'workflow' => 'registration',
			'autoSave' => true,
			'autoLog' => true,
		]);

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'className' => 'Users',
		]);
	}

	/**
	 * @param \Cake\Validation\Validator $validator Validator
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->integer('user_id')
			->allowEmptyString('user_id');

		$validator
			->scalar('session_id')
			->maxLength('session_id', 255)
			->allowEmptyString('session_id');

		$validator
			->scalar('status')
			->maxLength('status', 50)
			->notEmptyString('status');

		$validator
			->scalar('notes')
			->allowEmptyString('notes');

		return $validator;
	}

}
