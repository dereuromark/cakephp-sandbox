<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @extends \Cake\ORM\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior, Workflow: \Workflow\Model\Behavior\WorkflowBehavior}, \WorkflowSandbox\Model\Entity\Order>
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @method \WorkflowSandbox\Model\Entity\Order patchEntity(\WorkflowSandbox\Model\Entity\Order $entity, array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Order> patchEntities(iterable<\WorkflowSandbox\Model\Entity\Order> $entities, array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Order|false save(\WorkflowSandbox\Model\Entity\Order $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Order saveOrFail(\WorkflowSandbox\Model\Entity\Order $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Order>|false saveMany(iterable<\WorkflowSandbox\Model\Entity\Order> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Order> saveManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Order> $entities, array $options = [])
 * @method bool delete(\WorkflowSandbox\Model\Entity\Order $entity, array $options = [])
 * @method bool deleteOrFail(\WorkflowSandbox\Model\Entity\Order $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Order>|false deleteMany(iterable<\WorkflowSandbox\Model\Entity\Order> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Order> deleteManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Order> $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Workflow\Model\Behavior\WorkflowBehavior
 */
class OrdersTable extends Table {

	/**
	 * @param array<string, mixed> $config Configuration
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('workflow_orders');
		$this->setDisplayField('order_number');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Workflow.Workflow', [
			'workflow' => 'order',
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
			->scalar('order_number')
			->maxLength('order_number', 50)
			->notEmptyString('order_number');

		$validator
			->scalar('status')
			->maxLength('status', 50)
			->notEmptyString('status');

		$validator
			->decimal('total')
			->notEmptyString('total');

		$validator
			->scalar('payment_method')
			->maxLength('payment_method', 50)
			->allowEmptyString('payment_method');

		$validator
			->scalar('shipping_address')
			->allowEmptyString('shipping_address');

		return $validator;
	}

	/**
	 * Generate unique order number
	 *
	 * @return string
	 */
	public function generateOrderNumber(): string {
		return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
	}

}
