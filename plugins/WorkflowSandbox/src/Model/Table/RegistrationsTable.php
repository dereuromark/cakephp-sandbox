<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Registrations Model
 *
 * @extends \Cake\ORM\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior, Workflow: \Workflow\Model\Behavior\WorkflowBehavior}, \WorkflowSandbox\Model\Entity\Registration>
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @method \Cake\ORM\Query\SelectQuery<\WorkflowSandbox\Model\Entity\Registration> find(string $type = 'all', mixed ...$args)
 * @method \WorkflowSandbox\Model\Entity\Registration findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Registration patchEntity(\WorkflowSandbox\Model\Entity\Registration $entity, array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Registration> patchEntities(iterable<\WorkflowSandbox\Model\Entity\Registration> $entities, array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Registration|false save(\WorkflowSandbox\Model\Entity\Registration $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Registration saveOrFail(\WorkflowSandbox\Model\Entity\Registration $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Registration>|false saveMany(iterable<\WorkflowSandbox\Model\Entity\Registration> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Registration> saveManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Registration> $entities, array $options = [])
 * @method bool delete(\WorkflowSandbox\Model\Entity\Registration $entity, array $options = [])
 * @method bool deleteOrFail(\WorkflowSandbox\Model\Entity\Registration $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Registration>|false deleteMany(iterable<\WorkflowSandbox\Model\Entity\Registration> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Registration> deleteManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Registration> $entities, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Registration|array<\WorkflowSandbox\Model\Entity\Registration> loadInto(\WorkflowSandbox\Model\Entity\Registration|array<\WorkflowSandbox\Model\Entity\Registration> $entities, array $contain)
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
