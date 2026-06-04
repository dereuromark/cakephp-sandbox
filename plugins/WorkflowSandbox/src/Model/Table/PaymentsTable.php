<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Workflow\Model\Table\WorkflowTableTrait;
use Workflow\Model\WorkflowTableInterface;

/**
 * Payments Model
 *
 * @extends \Cake\ORM\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior, Workflow: \Workflow\Model\Behavior\WorkflowBehavior}, \WorkflowSandbox\Model\Entity\Payment>
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @method \WorkflowSandbox\Model\Entity\Payment patchEntity(\WorkflowSandbox\Model\Entity\Payment $entity, array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Payment> patchEntities(iterable<\WorkflowSandbox\Model\Entity\Payment> $entities, array<mixed> $data, array<string, mixed> $options = [])
 * @method \WorkflowSandbox\Model\Entity\Payment|false save(\WorkflowSandbox\Model\Entity\Payment $entity, array<string, mixed> $options = [])
 * @method \WorkflowSandbox\Model\Entity\Payment saveOrFail(\WorkflowSandbox\Model\Entity\Payment $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \WorkflowSandbox\Model\Entity\Payment>|false saveMany(iterable<\WorkflowSandbox\Model\Entity\Payment> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \WorkflowSandbox\Model\Entity\Payment> saveManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Payment> $entities, array<string, mixed> $options = [])
 * @method bool delete(\WorkflowSandbox\Model\Entity\Payment $entity, array<string, mixed> $options = [])
 * @method bool deleteOrFail(\WorkflowSandbox\Model\Entity\Payment $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \WorkflowSandbox\Model\Entity\Payment>|false deleteMany(iterable<\WorkflowSandbox\Model\Entity\Payment> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \WorkflowSandbox\Model\Entity\Payment> deleteManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Payment> $entities, array<string, mixed> $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Workflow\Model\Behavior\WorkflowBehavior
 */
class PaymentsTable extends Table implements WorkflowTableInterface {

	use WorkflowTableTrait;

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('workflow_sandbox_payments');
		$this->setDisplayField('transaction_id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Workflow.Workflow', [
			'workflow' => 'payment',
			'autoSave' => true,
			'autoLog' => true,
		]);

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'className' => 'Users',
		]);
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('transaction_id')
			->maxLength('transaction_id', 100)
			->allowEmptyString('transaction_id');

		$validator
			->decimal('amount')
			->requirePresence('amount', 'create')
			->notEmptyString('amount');

		$validator
			->scalar('currency')
			->maxLength('currency', 3)
			->allowEmptyString('currency');

		$validator
			->scalar('provider')
			->maxLength('provider', 50)
			->allowEmptyString('provider');

		return $validator;
	}

}
