<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Documents Model
 *
 * @extends \Cake\ORM\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior, Workflow: \Workflow\Model\Behavior\WorkflowBehavior}>
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Rejectors
 * @method \WorkflowSandbox\Model\Entity\Document newEmptyEntity()
 * @method \WorkflowSandbox\Model\Entity\Document newEntity(array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Document> newEntities(array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Document get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \WorkflowSandbox\Model\Entity\Document findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Document patchEntity(\WorkflowSandbox\Model\Entity\Document $entity, array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Document> patchEntities(iterable<\WorkflowSandbox\Model\Entity\Document> $entities, array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Document|false save(\WorkflowSandbox\Model\Entity\Document $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Document saveOrFail(\WorkflowSandbox\Model\Entity\Document $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Document>|false saveMany(iterable<\WorkflowSandbox\Model\Entity\Document> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Document> saveManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Document> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Document>|false deleteMany(iterable<\WorkflowSandbox\Model\Entity\Document> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Document> deleteManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Document> $entities, array $options = [])
 * @method \Cake\ORM\Query\SelectQuery<\WorkflowSandbox\Model\Entity\Document> find(string $type = 'all', mixed ...$args)
 * @method bool delete(\WorkflowSandbox\Model\Entity\Document $entity, array $options = [])
 * @method bool deleteOrFail(\WorkflowSandbox\Model\Entity\Document $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Document|array<\WorkflowSandbox\Model\Entity\Document> loadInto(\WorkflowSandbox\Model\Entity\Document|array<\WorkflowSandbox\Model\Entity\Document> $entities, array $contain)
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Workflow\Model\Behavior\WorkflowBehavior
 */
class DocumentsTable extends Table {

	/**
	 * @param array<string, mixed> $config Configuration
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('workflow_documents');
		$this->setDisplayField('title');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Workflow.Workflow', [
			'workflow' => 'document',
			'autoSave' => true,
			'autoLog' => true,
		]);

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'className' => 'Users',
		]);

		$this->belongsTo('Rejectors', [
			'foreignKey' => 'rejected_by',
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
			->scalar('title')
			->maxLength('title', 255)
			->notEmptyString('title');

		$validator
			->scalar('file_path')
			->maxLength('file_path', 500)
			->allowEmptyString('file_path');

		$validator
			->scalar('status')
			->maxLength('status', 50)
			->notEmptyString('status');

		$validator
			->integer('current_approver_level')
			->notEmptyString('current_approver_level');

		$validator
			->scalar('approved_by')
			->allowEmptyString('approved_by');

		$validator
			->integer('rejected_by')
			->allowEmptyString('rejected_by');

		$validator
			->scalar('rejection_reason')
			->allowEmptyString('rejection_reason');

		return $validator;
	}

}
