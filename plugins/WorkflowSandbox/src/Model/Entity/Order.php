<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $order_number
 * @property string $status
 * @property string|float $total
 * @property string|null $payment_method
 * @property string|null $shipping_address
 * @property \Cake\I18n\DateTime|null $paid_at
 * @property \Cake\I18n\DateTime|null $shipped_at
 * @property \Cake\I18n\DateTime|null $delivered_at
 * @property \Cake\I18n\DateTime|null $cancelled_at
 * @property \Cake\I18n\DateTime|null $refunded_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User|null $user
 */
class Order extends Entity {

	/**
	 * @var array<string, bool>
	 */
	protected array $_accessible = [
		'*' => true,
		'id' => false,
	];

}
